@extends('layouts.app')

@section('content')
<div class="bg-white min-h-screen">
    <div class="max-w-7xl mx-auto py-10 px-4 sm:py-18 sm:px-6 lg:px-8">
        <div class="text-center">
            <p class="mt-1 text-4xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight lg:text-6xl">Archiv</p>
            @if ($events->isEmpty())
                <p class="max-w-xl mt-5 mx-auto text-xl text-gray-500">Keine Events gefunden.</p>
            @endif
        </div>
@if ($events->count() != 0)
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto text-center">
            <div class="flex flex-wrap flex-row justify-center">
                @foreach ($events as $event)
                    @if($event->public)
                        <div
                            class="m-3 flex-initial bg-white overflow-hidden shadow rounded-lg divide-y divide-gray-200 w-48">
                            @if($event->preview_image==null)
                            <div class="px-4 py-5 sm:px-6">
                            @else
                            <div>
                            @endif
                                @if($event->preview_image!=null)
                                <img src="{{ url('/storage/' . $event->preview_image) }}" alt="{{ $event->name }}" class="w-full">
                                @else
                                {{ $event->name }}
                                @endif
                                <!-- Content goes here -->
                                <!-- We use less vertical padding on card headers on desktop than on body sections -->
                            </div>
                            <div class="px-4 py-5 sm:p-6 break-all">
                                {{ $event->description }}
                                <!-- Content goes here -->
                            </div>
                        </div>
                        @endif
                    @endforeach
            </div>
        </div>
    </div>
    </div>

</div>

@endif
<div class="bg-white h-full">
</div>
<div class="bg-white h-full">
</div>
<div class="bg-white h-full">
</div>
@endsection
