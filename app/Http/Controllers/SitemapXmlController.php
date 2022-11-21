<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Sitemap\SitemapGenerator;
use App\Models\Event;
use App\Models\Location;

class SitemapXmlController extends Controller
{
    public function index() {
        $events = Event::all()->where('public', true);
        $map= SitemapGenerator::create('https://www.campusleben-es.de')
            ->getSitemap();
        foreach ($events as $event) {
            $map->add(url('/events/'.$event->id), $event->updated_at, '0.9', 'daily');
        }

        $locations = Location::all()->where('clickable', true);
        foreach ($locations as $location) {
            $map->add(url('/l/'.$location->slug), $location->updated_at, '0.9', 'daily');
        }
        return $map->toResponse(request());
    }
}
