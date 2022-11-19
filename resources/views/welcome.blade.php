@extends('layouts.app')

@section('content')
    <div class="relative bg-white pt-8 pb-10 px-4 sm:px-6 lg:pt-10 lg:pb-12 lg:px-8">
        <div class="relative max-w-7xl mx-auto">
            <div class="text-center">
                <h2 class="text-3xl tracking-tight font-extrabold text-gray-900 sm:text-4xl">Willkommen!</h2>
                <h2 class="text-3xl tracking-tight font-extrabold text-gray-900 sm:text-4xl">Hier findet ihr alles was das
                    Studentenherz begehrt.</h2>
                <h2 class="text-3xl tracking-tight font-extrabold text-gray-900 sm:text-4xl"> #Campuswillleben</h2>
            </div>
            <div class="max-w-lg mx-auto p-5">
                <img style="max-height: 250px" class="mx-auto" src="{{ asset('storage/images/csm_logo_campusleben.png') }}"
                    alt="Logo">
            </div>
        </div>

        <div
            class="gap-4 my-5 grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 mx-auto max-w-md md:max-w-4xl sm:max-w-2xl lg:max-w-5xl">
            <div class="col-span-1">
                <a href="{{ route('cafe.einstein') }}">
                    <div class="h-48">
                        <img class="mx-auto max-h-48" src="{{ asset('storage/images/csm_logo_cafeeinstein.png') }}"
                            alt="Einstein">
                    </div>
                </a>
                <div class="max-w-xl text-center text-lg tracking-tight font-bold text-gray-900 sm:text-xl mt-2">
                    Café Einstein
                </div>
            </div>
            <div class="col-span-1">
                <a href="#">
                    <div class="h-48">
                        <img class="mx-auto max-h-48" src="{{ asset('storage/images/csm_logo_hzecafe.jpg') }}"
                            alt="Hze">
                    </div>
                </a>
                <div class="max-w-xl text-center text-lg tracking-tight font-bold text-gray-900 sm:text-xl mt-2">
                    Hze Café
                </div>
            </div>
            <div class="col-span-1">
                <a href="#">
                    <div class="h-48">
                        <img class="mx-auto max-h-48" src="{{ asset('storage/images/csm_logo_cafecampus.jpg') }}"
                            alt="Campus">
                    </div>
                </a>
                <div class="max-w-xl text-center text-lg tracking-tight font-bold text-gray-900 sm:text-xl mt-2">
                    Café Campus
                </div>
            </div>
        </div>
        @if (!empty($sponsors))
            <div class="bg-white h-100">
                <div class="mx-auto max-w-7xl pb-3 px-4 sm:px-6 lg:px-8">
                    <div class="mt-0 flex justify-center gap-0.5 md:grid-cols-3 lg:mt-0">
                        <div class="gap-3 flex justify-center bg-white py-0 px-0">
                            @foreach ($sponsors as $sponsor)
                                <a href="{{ $sponsor->link }}" target="_blank">
                                    <img class="max-h-20 w-100" src="{{ asset('storage/' . $sponsor->image) }}"
                                        alt="{{ $sponsor->name }}">
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
