<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sitemap\Tags\Url;

class Event extends Model
{
    use HasFactory;

    public function sponsors(): BelongsToMany
    {
        return $this->belongsToMany(Sponsor::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    //boot
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($event) {
            // detach attending users.
            $event->users()->detach();
            // detach sponsoring
            $event->sponsors()->detach();
            // delete associated posts
            $posts = $event->posts;
            foreach ($posts as $post) {
                $post->delete();
            }
            // delete previous associated image.
            $picture = $event->preview_image;
            if ($picture) {
                $picturePath = storage_path('app/public/'.$picture);
                if (file_exists($picturePath)) {
                    unlink($picturePath);
                }
            }
        });

        static::deleted(function ($event) {
            $log = new LOG;
            $log->user_email = auth()->user()->email;
            $log->action = 'Event deleted: '.$event->name;
            $log->type = 'delete';
            $log->save();
        });

        static::updated(function ($event) {
            $log = new LOG;
            $log->user_email = auth()->user()->email;
            $log->action = 'Event updated: '.$event->name;
            $log->type = 'update';
            $log->save();
        });

        static::created(function ($event) {
            $log = new LOG;
            $log->user_email = auth()->user()->email;
            $log->action = 'Event created: '.$event->name;
            $log->type = 'create';
            $log->save();
        });
    }

    /**
     * Gets all the posts that are related to this event.
     *
     **/
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function toSitemapTag(): Url|string|array
    {
        return route('events.show', $this->id);
    }
}
