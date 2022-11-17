<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - {{ (isset($title)) ? $title : 'Start' }}</title>
    <meta property="og:title" content="{{ config('app.name', 'Laravel') }} - {{ (isset($title)) ? $title : 'Start' }}">
    <meta name="twitter:title" content="{{ config('app.name', 'Laravel') }} - {{ (isset($title)) ? $title : 'Start' }}">

    <meta name="description" content="{{ (isset($metaDescription)) ? $metaDescription : 'Hier findet ihr alles was das Studentenherz begehrt.' }}">
    <meta property="og:description" content="{{ (isset($metaDescription)) ? $metaDescription : 'Hier findet ihr alles was das Studentenherz begehrt.' }}">
    <meta name="twitter:description" content="{{ (isset($metaDescription)) ? $metaDescription : 'Hier findet ihr alles was das Studentenherz begehrt.' }}">

    <meta property="og:image" content="{{ (isset($metaImage) && $metaImage != null) ? $metaImage : asset('storage/images/csm_logo_campusleben.png') }}">
    <meta name="twitter:image" content="{{ (isset($metaImage) && $metaImage != null) ? $metaImage : asset('storage/images/csm_logo_campusleben.png') }}">

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/app.css'])

    <style>
        [x-cloak] {
            display: none !important
        }
    </style>
    <link rel="stylesheet" type="text/css" href="{{asset("vendor/cookie-consent/css/cookie-consent.css")}}">
    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-T6VXW4W');
    </script>
    <!-- End Google Tag Manager -->
</head>

<body class="min-h-screen" x-data="{ solutionflyout: false, moreflyout: false, mobilemenu: false }">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T6VXW4W" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div class="flex flex-col min-h-screen justify-between">
        <div class="relative bg-white flex-shrink-0">
            <div class="flex justify-between items-center px-4 py-6 sm:px-6 md:justify-start md:space-x-10">
                <div>
                    <a href="{{ route('home') }}" class="flex">
                        <span class="sr-only">CampusLeben</span>
                        <img class="h-8 w-auto sm:h-10" src="{{ asset('storage/images/csm_logo_campusleben.png') }}"
                            alt="">
                    </a>
                </div>
                <div class="-mr-2 -my-2 md:hidden">
                    <button @click="mobilemenu = true" type="button"
                        class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
                        aria-expanded="false">
                        <span class="sr-only">Open menu</span>
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
                <div class="hidden md:flex-1 md:flex md:items-center md:justify-between">
                    <nav class="flex space-x-10">
                        <div class="relative">
                            <button @click="solutionflyout = ! solutionflyout" type="button"
                                class="text-gray-500 group bg-white rounded-md inline-flex items-center text-base font-medium hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                aria-expanded="false">
                                <span>Menü</span>
                                <svg class="text-gray-400 ml-2 h-5 w-5 group-hover:text-gray-500"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div x-cloak x-show="solutionflyout" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 translate-y-1"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 translate-y-1" @click.outside="solutionflyout = false"
                                class="absolute z-10 -ml-4 mt-3 transform w-screen max-w-md lg:max-w-3xl">
                                <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden">
                                    <div class="relative grid gap-6 bg-white px-5 py-6 sm:gap-8 sm:p-8 lg:grid-cols-2">
                                        <a href="{{ route('home') }}"
                                            class="-m-3 p-3 flex items-start rounded-lg hover:bg-gray-50">
                                            <div
                                                class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-md bg-indigo-500 text-white sm:h-12 sm:w-12">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-base font-medium text-gray-900">Home</p>
                                                <p class="mt-1 text-sm text-gray-500">Startseite</p>
                                            </div>
                                        </a>

                                        <a href="{{ route('events.index') }}"
                                            class="-m-3 p-3 flex items-start rounded-lg hover:bg-gray-50">
                                            <div
                                                class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-md bg-indigo-500 text-white sm:h-12 sm:w-12">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-base font-medium text-gray-900">Events</p>
                                                <p class="mt-1 text-sm text-gray-500">Was steht an?!</p>
                                            </div>
                                        </a>

                                        <a href="{{ route('events.archive') }}"
                                            class="-m-3 p-3 flex items-start rounded-lg hover:bg-gray-50">
                                            <div
                                                class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-md bg-indigo-500 text-white sm:h-12 sm:w-12">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-base font-medium text-gray-900">Archiv</p>
                                                <p class="mt-1 text-sm text-gray-500">Die Vergangenheit spricht Bände.
                                                </p>
                                            </div>
                                        </a>

                                        <a href="{{ route('contact') }}"
                                            class="-m-3 p-3 flex items-start rounded-lg hover:bg-gray-50">
                                            <div
                                                class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-md bg-indigo-500 text-white sm:h-12 sm:w-12">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-base font-medium text-gray-900">Kontakt</p>
                                                <p class="mt-1 text-sm text-gray-500">Immer ein offenes Ohr.</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="relative">
                            <button @click="moreflyout = ! moreflyout" type="button"
                                class="text-gray-500 group bg-white rounded-md inline-flex items-center text-base font-medium hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                aria-expanded="false">
                                <span>Mehr</span>
                                <svg class="text-gray-400 ml-2 h-5 w-5 group-hover:text-gray-500"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div x-cloak x-show="moreflyout" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 translate-y-1"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 translate-y-1" @click.outside="moreflyout = false"
                                class="absolute z-10 left-1/2 transform -translate-x-1/2 mt-3 px-2 w-screen max-w-xs sm:px-0">
                                <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden">
                                    <div class="relative grid gap-6 bg-white px-5 py-6 sm:gap-8 sm:p-8">
                                        <a href="{{ route('about') }}"
                                            class="-m-3 p-3 block rounded-md hover:bg-gray-50">
                                            <p class="text-base font-medium text-gray-900">Über uns</p>
                                            <p class="mt-1 text-sm text-gray-500">Wer wir sind</p>
                                        </a>

                                        <a href="{{ route('impressum') }}"
                                            class="-m-3 p-3 block rounded-md hover:bg-gray-50">
                                            <p class="text-base font-medium text-gray-900">Impressum</p>
                                            <p class="mt-1 text-sm text-gray-500">Was muss das muss.</p>
                                        </a>

                                        <a href="{{ route('datenschutz') }}"
                                            class="-m-3 p-3 block rounded-md hover:bg-gray-50">
                                            <p class="text-base font-medium text-gray-900">Datenschutz</p>
                                            <p class="mt-1 text-sm text-gray-500">Deine Daten sind bei uns sicher.</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </nav>
                    <div class="flex items-center md:ml-12">
                        @guest
                            <a href="{{ route('login') }}"
                                class="text-base font-medium text-gray-500 hover:text-gray-900">
                                Anmelden </a>
                            <a href="{{ route('register') }}"
                                class="ml-8 inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                                Registrieren </a>
                        @else
                            <div x-cloak x-data="{ loggedinshow: false }" @click.outside="loggedinshow = false"
                                class="relative inline-block text-left">
                                <div>
                                    <button @click="loggedinshow = ! loggedinshow" type="button"
                                        class="inline-flex justify-center w-full  px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900"
                                        id="menu-button" aria-expanded="true" aria-haspopup="true">
                                        {{ Auth::user()->name }}
                                        <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                                <div x-show="loggedinshow" x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="transform opacity-100 scale-100"
                                    x-transition:leave-end="transform opacity-0 scale-95"
                                    class="z-10 origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none"
                                    role="menu" aria-orientation="vertical" aria-labelledby="menu-button"
                                    tabindex="-1">
                                    <div class="px-4 py-3" role="none">
                                        <p class="text-sm" role="none">Angemeldet als</p>
                                        <p class="text-sm font-medium text-gray-900 truncate" role="none">
                                            {{ Auth::user()->email }}</p>
                                    </div>
                                    @admin
                                        <div class="py-1" role="none">
                                            <a href="{{ route('admin.dashboard') }}"
                                                class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1"
                                                id="menu-item-0">Admin Dashboard</a>
                                        </div>
                                    @endadmin
                                    <div class="py-1" role="none">
                                        <form method="POST" action="{{ route('logout') }}" role="none">
                                            @csrf
                                            <button type="submit"
                                                class="text-gray-700 block w-full text-left px-4 py-2 text-sm"
                                                role="menuitem" tabindex="-1" id="menu-item-3">Abmelden</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
            <div class="z-10" x-cloak x-show="mobilemenu" x-transition:enter="duration-200 ease-out"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="duration-100 ease-in" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute top-0 inset-x-0 p-2 transition transform origin-top-right md:hidden">
                <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-white divide-y-2 divide-gray-50">
                    <div class="pt-5 pb-6 px-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <img class="h-8 w-auto" src="{{ asset('storage/images/csm_logo_campusleben.png') }}"
                                    alt="Workflow">
                            </div>
                            <div class="-mr-2">
                                <button @click="mobilemenu = false" type="button"
                                    class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                                    <span class="sr-only">Menü schließen</span>
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="mt-6">
                            <nav class="grid gap-6">
                                <a href="{{ route('home') }}"
                                    class="-m-3 p-3 flex items-center rounded-lg hover:bg-gray-50">
                                    <div
                                        class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-md bg-indigo-500 text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                    </div>
                                    <div class="ml-4 text-base font-medium text-gray-900">Home</div>
                                </a>

                                <a href="{{ route('events.index') }}"
                                    class="-m-3 p-3 flex items-center rounded-lg hover:bg-gray-50">
                                    <div
                                        class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-md bg-indigo-500 text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4 text-base font-medium text-gray-900">Events</div>
                                </a>

                                <a href="{{ route('events.archive') }}"
                                    class="-m-3 p-3 flex items-center rounded-lg hover:bg-gray-50">
                                    <div
                                        class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-md bg-indigo-500 text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                        </svg>
                                    </div>
                                    <div class="ml-4 text-base font-medium text-gray-900">Archiv</div>
                                </a>

                                <a href="{{ route('contact') }}"
                                    class="-m-3 p-3 flex items-center rounded-lg hover:bg-gray-50">
                                    <div
                                        class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-md bg-indigo-500 text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                    </div>
                                    <div class="ml-4 text-base font-medium text-gray-900">Kontakt</div>
                                </a>
                                @admin
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="-m-3 p-3 flex items-center rounded-lg hover:bg-gray-50">
                                        <div
                                            class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-md bg-indigo-500 text-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                                            </svg>

                                        </div>
                                        <div class="ml-4 text-base font-medium text-gray-900">Admin Dashboard</div>
                                    </a>
                                @endadmin
                            </nav>
                        </div>
                    </div>
                    <div class="py-6 px-5">
                        <div class="grid grid-cols-3 gap-4">

                            <a href="{{ route('impressum') }}"
                                class="text-base font-medium text-gray-900 hover:text-gray-700"> Impressum
                            </a>

                            <a href="{{ route('datenschutz') }}"
                                class="text-base font-medium text-gray-900 hover:text-gray-700"> Datenschutz
                            </a>

                            <a href="{{ route('about') }}"
                                class="text-base font-medium text-gray-900 hover:text-gray-700"> Über uns
                            </a>
                        </div>
                        @guest
                            <div class="mt-6">
                                <a href="{{ route('register') }}"
                                    class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                                    Registrieren </a>
                                <p class="mt-6 text-center text-base font-medium text-gray-500">
                                    Du hast schon einen Account?
                                    <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-500">
                                        Anmelden
                                    </a>
                                </p>
                            </div>
                        @else
                            <div class="mt-6">
                                <form method="POST" action="{{ route('logout') }}" role="none">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700"
                                        role="menuitem" tabindex="-1" id="menu-item-3">Abmelden</button>
                                </form>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </div>

        <main class="min-h-screen mb-auto flex-grow-1 flex-shrink-0 basis-auto bg-white">
            @yield('content')
        </main>
        <footer class="bg-white m-auto w-full h-fit flex-shrink-0">
            <div class="max-w-7xl mx-auto py-10 px-4 sm:px-4 md:flex md:items-center md:justify-between lg:px-6">
                <div class="flex justify-center space-x-6 md:order-2">
                    <a href="https://www.facebook.com/CampusLebenEsslingen/"
                        class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Facebook</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>

                    <a href="https://www.instagram.com/campus_leben/" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Instagram</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
                <div class="mt-8 md:mt-0 md:order-1">
                    <p class="text-center text-base text-gray-400">&copy; {{ env('COPYRIGHT', '2022') }} Campus Leben,
                        e.V. Alle Rechte vorbehalten</p>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>
