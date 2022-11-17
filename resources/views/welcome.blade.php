@extends('layouts.app')

@section('content')
    <div class="relative bg-white pt-16 pb-10 px-4 sm:px-6 lg:pt-24 lg:pb-12 lg:px-8">
        <div class="relative max-w-7xl mx-auto">
            <div class="text-center">
                <h2 class="text-3xl tracking-tight font-extrabold text-gray-900 sm:text-4xl">Willkommen!</h2>
                <h2 class="text-3xl tracking-tight font-extrabold text-gray-900 sm:text-4xl">Hier findet ihr alles was das
                    Studentenherz begehrt.</h2>
                <h2 class="text-3xl tracking-tight font-extrabold text-gray-900 sm:text-4xl"> #Campuswillleben</h2>
            </div>
            <div class="max-w-7xl mx-auto p-5">
                <img style="max-height: 250px" class="mx-auto" src="{{ asset('storage/images/csm_logo_campusleben.png') }}"
                    alt="Logo">
            </div>
        </div>
        @if (!empty($sponsors))
            <div class="bg-white h-100">
                <div class="mx-auto max-w-7xl pb-12 pt-3 px-4 sm:px-6 lg:pb-16 lg:pt-4 lg:px-8">
                    <div class="mt-0 flex justify-center gap-0.5 md:grid-cols-3 lg:mt-0">
                        <div class="gap-3 flex justify-center bg-gray-50 py-0 px-0">
                            @foreach ($sponsors as $sponsor)
                                <img class="max-h-20 w-100" src="{{ asset('storage/' . $sponsor->image) }}"
                                    alt="{{ $sponsor->name }}">
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
