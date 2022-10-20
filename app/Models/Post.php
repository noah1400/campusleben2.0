<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Post extends Model
{
    use HasFactory;

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // boot
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($post) {
            $picture = $post->picture;
            // delete previous associated image.
            if ($picture != null) {
                $picturePath = storage_path('app/public/' . $picture);
                if (file_exists($picturePath)) {
                    unlink($picturePath);
                }
            }
        });
    }

}
