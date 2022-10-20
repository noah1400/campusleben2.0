<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;

class Event extends Model
{
    use HasFactory;

    public function sponsors() {
        return $this->belongsToMany(Sponsor::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    //boot
    protected static function boot()
    {
        parent::boot();

        static::deleting(function($event) {
            // detach attending users.
            $event->users()->detach();
            // detach sponsoring
            $event->sponsors()->detach();
            // delete associated posts
            $posts = $event->posts;
            foreach ($posts as $post){
                $post->delete();
            }
            // delete previous associated image.
            $picture = $event->preview_image;
            if ($picture) {
                $picturePath = storage_path('app/public/' . $picture);
                if (file_exists($picturePath)) {
                    unlink($picturePath);
                }
            }
        });
    }
    /**
     * Gets all the posts that are related to this event.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function toSitemapTag(): Url | string | array
    {
        return route('events.show', $this->id);
    }

}
