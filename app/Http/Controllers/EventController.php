<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use \Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use GrahamCampbell\Markdown\Facades\Markdown;

class EventController extends Controller
{

    /**
     * EventController
     * Controlls everything related to events
     */


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        //get all events that are not expired
        $events = Event::where('end_date', '>=', Carbon::now())
        ->where('public', true)
        ->orderBy('start_date', 'asc')
        ->get();

        foreach($events as $event){
            // format date of each event
            $event->start_date = Carbon::parse($event->start_date)
            ->locale('de')
            ->isoFormat('dd. DD.MM.YYYY H:mm');
            $event->end_date = Carbon::parse($event->end_date)
            ->locale('de')
            ->isoFormat('dd. DD.MM.YYYY H:mm');
            // shorten description
            $event->description = Str::limit($event->description, 80, '...');
            // remove line breaks
            $event->description = str_replace(array("\r", "\n"), ' ', $event->description);
        }
        $title = "Events";

        $quotes = [
            'Die Zukunft gehört den Machern – nicht den Zauderern.',
            'Ein Leben ohne Feste gleicht einer weiten Reise ohne Einkehr.',
            'A little party never killed nobody!',
            'Die Zukunft ist ein Fest, das noch vor uns liegt.',
            'Ein Fest ist immer nur so gut wie die Gäste, die es besuchen.',
            'Ein Fest ohne Musik ist wie ein Körper ohne Seele.',
            'Bier auf Wein, das lass sein',
            'Lieber Rum trinken, als rumsitzen!',
            'Ich sage immer nein zu Alkohol. Aber er hört einfach nicht auf mich.',
            'Alkohol ist die Lösung. Aber was ist die Frage?',
            'Die Zukunft kann man am besten voraussagen, wenn man sie selbst gestaltet.',
            'Man muss die Zukunft abwarten und die Gegenwart genießen... oder ertragen.',
            'Geduld ist nicht so einfach. Aber - nach meiner Erfahrung - meist zielführend.',
            'Beim Warten kann man Geduld üben.',
            'Warten bedeutet, dass das, worauf man wartet, wichtiger ist als das, was jetzt ist.',
            'Eat, Sleep, Party, Repeat',
            'Wenn ich morgen Augenringe habe das täuscht, das sind nur Schatten von großen Taten.',
            'Feiern macht abhängig. Gar nicht erst damit anfangen liebe Kinder.',
            'Alkohol ist keine Antwort, doch beim feiern vergisst man die Frage!',
            'Ich geh erst nach Hause, wenn es hell ist. Nichts das mir noch was passiert!',
            'Eine Klausur kann man wiederholen, eine Party nicht.',
            'Lass uns Achtarmig einen reinorgeln.',
            'Do it for the vine.',
            /*
            'Welcome to Bible Study. We’re all children of Jesus… Kumbaya my looordd.'
            */
            'Lass uns Hopfen und Malz wiederfinden.',
            'Lass uns den Kranplatz nachverdichten.',
            'Der Lärm ist die Seele der Party-Musik.',
            'Wozu erst arbeiten, gleich feiern!',
            'Lieber krank feiern, als gesund arbeiten.',
            'Die Zukunft der Zukunft liegt in der Zukunft.',
            'Zukunft ist ein Kind der Gegenwart.'
        ];

        $quote = $quotes[array_rand($quotes)];

        return view('events.index', compact('events','title', 'quote'));
    }

    public function archive(){
        //get all events that are expired
        //get all events that are not expired
        $events = Event::where('end_date', '<', Carbon::now())
        ->where('public', true)
        ->orderBy('start_date', 'desc')
        ->get();

        foreach($events as $event){
            // format date of each event
            $event->start_date = Carbon::parse($event->start_date)
            ->locale('de')
            ->isoFormat('dd. DD.MM.YYYY H:mm');
            $event->end_date = Carbon::parse($event->end_date)
            ->locale('de')
            ->isoFormat('dd. DD.MM.YYYY H:mm');
            // shorten description
            $event->description = Str::limit($event->description, 80, '...');
            // remove line breaks
            $event->description = str_replace(array("\r", "\n"), ' ', $event->description);
        }
        $title="Archiv";

        $quotes = [
            'Auch wenn du zurückschaust, schaust du nach vorne.',
            'Die Vergangenheit vergeht nicht, sie ist immer gegenwärtig.',
            'Auf älteren Fotos sieht man jünger aus.',
            'Wer vor der Vergangenheit die Augen verschließt, wird blind für die Gegenwart.',
            'Wer in der Zukunft lesen will, muss in der Vergangenheit blättern.',
            'Was einmal war, verläßt uns nicht.',
            'Die Vergangenheit begegnet uns jeden Tag, weil sie nie vergangen ist.',
            'Wer nicht manchmal stehenbleibt und zurückschaut, weiß gar nicht, wie weit er schon gekommen ist.',
            'Auch der Schnee von gestern fiel einst frisch vom Himmel.',
            'Man sollte an die Vergangenheit denken, ohne sich mit allzu schwermütiger Sehnsucht in sie zu versenken.'
        ];

        $quote = $quotes[array_rand($quotes)];

        return view('events.archive', compact('events', 'title', 'quote'));
    }

    /**
     * Shows all the events that the user is attending.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function myevents(){
        $events = auth()->user()->events;
        return view('events.myevents', compact('events'));
    }





    public function attend(Request $request, $id)
    {
        $user = auth()->user();
        if ($user->events->contains($id)){
            return redirect()->route('events.myevents');
        }
        $event = Event::findOrFail($id);
        $user->events()->attach($event);
        return redirect()->route('events.myevents');
    }

    /**
     * Shows the event with the given id.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id){
        $event = Event::findOrFail($id);
        if ($event->public == false){
            // return 404
            if ( Auth::check() == false){
                abort(404);
            }else{
                if (Auth::user()->isAdmin == false){
                    abort(404);
                }
            }
        }
        //Convert date to format d.m.Y H:i
        $event->start_date = Carbon::parse($event->start_date)
        ->locale('de')
        ->isoFormat('dd. DD.MM.YYYY H:mm');
        $event->end_date = Carbon::parse($event->end_date)
        ->locale('de')
        ->isoFormat('dd. DD.MM.YYYY H:mm');

        // add sponsors to event
        $sponsors = $event->sponsors;

        // Meta Tags
        $metaDescription = $event->description;
        $metaImage = asset('storage/'.$event->preview_image);

        // Convert markdown to html
        $event->description = Markdown::convert($event->description)->getContent();
        $title = $event->name;



        return view('events.show', compact('event', 'title', 'metaDescription', 'metaImage'));
    }



    public function countUsers($id){

        $event = Event::findOrFail($id);
        if($event->public == false){
            if(Auth::check() == false){
                abort(404);
            }else{
                if(Auth::user()->isAdmin == false){
                    abort(404);
                }
            }
        }
        $users = $event->users;
        return response()->json(['count' => $users->count()]);
    }
}
