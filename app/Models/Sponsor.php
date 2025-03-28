<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sponsor extends Model
{
    use HasFactory;

    protected $table = 'sponsors';

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class);
    }

    //boot
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($sponsor) {
            // detach sponsoring
            $sponsor->events()->detach();
            // delete image
            $image = storage_path('app/public/'.$sponsor->image);
            if (file_exists($image)) {
                unlink($image);
            }
        });

        static::deleted(function ($sponsor) {
            $log = new LOG;
            $log->user_email = auth()->user()->email;
            $log->action = 'Sponsor deleted: '.$sponsor->name;
            $log->type = 'delete';
            $log->save();
        });

        static::updated(function ($sponsor) {
            $log = new LOG;
            $log->user_email = auth()->user()->email;
            $log->action = 'Sponsor updated: '.$sponsor->name;
            $log->type = 'update';
            $log->save();
        });

        static::created(function ($sponsor) {
            $log = new LOG;
            $log->user_email = auth()->user()->email;
            $log->action = 'Sponsor created: '.$sponsor->name;
            $log->type = 'create';
            $log->save();
        });
    }
}
