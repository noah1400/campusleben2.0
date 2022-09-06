@extends('layouts.app')

@section('content')
    <div class="relative py-16 bg-white overflow-hidden min-h-screen">
        <div class="relative px-4 sm:px-6 lg:px-8">
            <div class="text-lg max-w-prose mx-auto">
                <h1>
                    <span
                        class="mt-2 block text-3xl text-center leading-8 font-bold tracking-tight text-gray-900 sm:text-4xl">Kontakt</span>
                </h1>
                <p class="mt-8 text-xl text-gray-500 leading-8">CampusLeben ev. <br>
                    Kanalstraße 33<br>
                    73728 Esslingen am Neckar <br></p>
                <p class="text-xl text-gray-500 leading-8">
                    <strong>Vertreten durch: </strong><br>
                    Tristan Eberhardt (zweiter Vorsitzender)<br>
                </p>
                <p class="text-xl text-gray-500 leading-8">
                    <strong>Kontakt:</strong> <br>
                    Telefon: 0711 397-3498<br>
                    E-Mail: <a href='mailto:campusleben@hs-esslingen.de'>campusleben@hs-esslingen.de</a><br>
                </p>
            </div>
            <div class="mt-6 prose prose-indigo prose-lg text-gray-500 mx-auto">
                <p><span data-feather="instagram"></span>
                    <a class="h4 text-decoration-none" href="https://www.instagram.com/campus_leben/" target="_blank">@campus_leben</a>
                </p>
                <p><span data-feather="instagram"></span>
                    <a class="h4 text-decoration-none" href="https://www.instagram.com/cafeeinsteinhs/" target="_blank">@cafeeinsteinhs</a></p>
                <h2>Discord</h2>
                <iframe src="https://discord.com/widget?id=953312705513680967&theme=dark" width="350" height="500" allowtransparency="true" frameborder="0" sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts"></iframe>
            </div>
            <div class="mt-6 prose prose-indigo prose-lg text-gray-500 mx-auto">

                <p class="text-xl text-gray-500 leading-8">
                    <strong>Fehler melden:</strong><br>
                    Du hast einen Fehler oder eine Sicherheitslücke auf unserer Website entdeckt?<br>
                    Dann melde dich bitte bei uns entweder per E-Mail, Instagram, Discord oder melde den Fehler direkt bei
                    <a href="https://github.com/noah1400/campusleben2.0"> GitHub</a>.
            </p>
            </div>
        </div>
    </div>
@endsection
