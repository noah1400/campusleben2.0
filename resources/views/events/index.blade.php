@extends('layouts.app')

@section('content')
    <div class="bg-white min-h-screen">
        <div class="max-w-7xl mx-auto py-10 px-4 sm:py-18 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="mt-1 text-4xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight lg:text-6xl">Events</p>
                @if ($events->isEmpty())
                    <p class="max-w-xl mt-5 mx-auto text-xl text-gray-500">Keine Events gefunden.</p>
                @else
                    <p class="max-w-xl mt-5 mx-auto text-xl text-gray-500">Das erwartet dich in nächster Zeit.</p>
                @endif
            </div>
    @if ($events->count() != 0)
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-5xl mx-auto text-center">
                <div class="flex flex-wrap flex-row justify-center">
                    @foreach ($events as $event)
                    @if($event->public)
                    <a href="{{ route('events.show', $event) }}">
                        <div
                            class="transition transform hover:-translate-y-1 motion-reduce:transition-none motion-reduce:hover:transform-none m-3 flex-initial bg-white overflow-hidden shadow rounded-lg divide-y divide-gray-200 w-72 h-80">
                            @if($event->preview_image==null)
                            <div class="px-4 py-5 sm:px-6 h-1/2 overflow-y-hidden">
                            @else
                            <div class="h-1/2 overflow-y-hidden">
                            @endif
                                @if($event->preview_image!=null)
                                <img src="{{ url('/storage/' . $event->preview_image) }}" alt="{{ $event->name }}" class="w-full">
                                @else
                                <p class="sm:text-xl lg:text-2xl">{{ $event->name }}</p>
                                @endif
                            </div>
                            <div class="px-4 py-2 sm:p-6 break-all h-1/2 whitespace-pre-line">
                                {{ $event->description }}
                            </div>
                        </div>
                    </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        </div>

    </div>

    @endif
@endsection
