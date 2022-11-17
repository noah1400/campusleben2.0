@extends('layouts.app')

@section('content')
    <div class="relative py-16 bg-white overflow-hidden min-h-screen">
        <div class="hidden lg:block lg:absolute lg:inset-y-0 lg:h-full lg:w-full">
            <div class="relative h-full text-lg max-w-prose mx-auto" aria-hidden="true">
                <svg class="absolute top-12 left-full transform translate-x-32" width="404" height="384" fill="none"
                    viewBox="0 0 404 384">
                    <defs>
                        <pattern id="74b3fd99-0a6f-4271-bef2-e80eeafdf357" x="0" y="0" width="20"
                            height="20" patternUnits="userSpaceOnUse">
                            <rect x="0" y="0" width="4" height="4" class="text-gray-200"
                                fill="currentColor" />
                        </pattern>
                    </defs>
                    <rect width="404" height="384" fill="url(#74b3fd99-0a6f-4271-bef2-e80eeafdf357)" />
                </svg>
                <svg class="absolute top-3/4 right-full transform -translate-y-1/2 -translate-x-32" width="404"
                    height="384" fill="none" viewBox="0 0 404 384">
                    <defs>
                        <pattern id="f210dbf6-a58d-4871-961e-36d5016a0f49" x="0" y="0" width="20"
                            height="20" patternUnits="userSpaceOnUse">
                            <rect x="0" y="0" width="4" height="4" class="text-gray-200"
                                fill="currentColor" />
                        </pattern>
                    </defs>
                    <rect width="404" height="384" fill="url(#f210dbf6-a58d-4871-961e-36d5016a0f49)" />
                </svg>
            </div>
        </div>
        <div class="relative px-4 sm:px-6 lg:px-8">
            <div class="mt-6 prose prose-indigo prose-lg text-gray-500 mx-auto">

                <figure>
                    <img class="w-fit mx-auto rounded-lg h-32" src="{{ asset('storage/images/csm_logo_cafeeinstein.png') }}"
                        alt="">
                </figure>
            </div>
            <div class="text-lg max-w-prose mx-auto">
                <h1>
                    <span
                        class="mt-2 block text-3xl text-center leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">CafeEinstein</span>
                </h1>
                <p class="mt-2 text-xl text-gray-500 leading-8">Das Café Einstein ist der Ort, an dem sich Studierende aller Fakultäten des Standortes Esslingen Campus Stadtmitte treffen.
                    Die Studierenden erhalten im Café nicht nur Kaffee, Kaltgetränke und Snacks, sondern können gemeinsam die Pausenzeiten mit Hilfe eines Tischkickers und einem Billardtisch aktiv gestalten.</p>
                    <p class="mt-2 text-xl text-gray-500 leading-8">Außerdem zeigt das Café Einstein regelmäßig den Tatort und andere Filme.</p>
                    <p class="mt-2 text-xl text-gray-500 leading-8">Du willst wissen, welcher Film als nächstes im Einstein läuft oder wann das Einstein mal wieder außerplanmäßig öffnet? Dann folge dem Café Einstein auf Instagram oder FACEBOOK.</p>
                    <p class="mt-2 text-xl text-gray-500 leading-8"> <strong class="">Öffnungszeiten: </strong> </p>
                    <p class="mt-2 text-xl text-gray-500 leading-8">
                        1. Pause: 09:05-09:30 Uhr <br>
                        2. Pause: 11:00-11:15 Uhr <br>
                        3. Pause: 12:45-13:30 Uhr
                    </p>
                    <p class="mt-2 text-xl text-gray-500 leading-8">...und immer, wenn die Türe offen steht.</p>
                    <p class="mt-2 text-xl text-gray-500 leading-8">
                        Dienstags: Kino ab 19:45 Uhr <br>
                        Donnerstags: Kneipe ab 19:45 Uhr <br>
                        Sonntags: Tatort ab 19:45 Uhr
                    </p>
                    <p class="mt-2 text-xl text-gray-500 leading-8">
                        <strong>Campus Stadtmitte</strong> <br>
                        S08.004
                    </p>
                </div>

        </div>
    </div>
@endsection
