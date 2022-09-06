<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Sitemap\SitemapGenerator;
use App\Models\Event;

class SitemapXmlController extends Controller
{
    public function index() {
        $events = Event::all()->where('public', true);
        $map= SitemapGenerator::create('https://www.campusleben-es.de')
            ->getSitemap();
        foreach ($events as $event) {
            $map->add(url('/events/'.$event->id), $event->updated_at, '0.9', 'daily');
        }
        return $map->toResponse(request());
    }
}
