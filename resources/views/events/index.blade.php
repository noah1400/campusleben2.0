@extends('events.eventlayout')

@section('header')
    <p class="mt-1 text-4xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight lg:text-6xl">Events</p>
    @if ($events->isEmpty())
        <p class="max-w-xl mt-5 mx-auto text-xl text-gray-500">Keine Events gefunden.</p>
    @else
        <p class="max-w-xl mt-5 mx-auto text-xl text-gray-500">Das erwartet dich in nächster Zeit.</p>
    @endif
@endsection
