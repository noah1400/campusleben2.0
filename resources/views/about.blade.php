@extends('layouts.app')

@section('content')
<div class="relative py-16 bg-white overflow-hidden min-h-screen">
    <div class="hidden lg:block lg:absolute lg:inset-y-0 lg:h-full lg:w-full">
      <div class="relative h-full text-lg max-w-prose mx-auto" aria-hidden="true">
        <svg class="absolute top-12 left-full transform translate-x-32" width="404" height="384" fill="none" viewBox="0 0 404 384">
          <defs>
            <pattern id="74b3fd99-0a6f-4271-bef2-e80eeafdf357" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
              <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
            </pattern>
          </defs>
          <rect width="404" height="384" fill="url(#74b3fd99-0a6f-4271-bef2-e80eeafdf357)" />
        </svg>
        <svg class="absolute top-3/4 right-full transform -translate-y-1/2 -translate-x-32" width="404" height="384" fill="none" viewBox="0 0 404 384">
          <defs>
            <pattern id="f210dbf6-a58d-4871-961e-36d5016a0f49" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
              <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
            </pattern>
          </defs>
          <rect width="404" height="384" fill="url(#f210dbf6-a58d-4871-961e-36d5016a0f49)" />
        </svg>
      </div>
    </div>
    <div class="relative px-4 sm:px-6 lg:px-8">
      <div class="text-lg max-w-prose mx-auto">
        <h1>
          <span class="mt-2 block text-3xl text-center leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">Über uns</span>
        </h1>
        <p class="mt-8 text-xl text-gray-500 leading-8">Seit dem Jahr 2011 nimmt CampusLeben viele Aufgaben innerhalb der Hochschule mit und für die Studierenden nach dem Motto "Mit Freunden etwas bewegen" wahr. CampusLeben hat es sich zum primären Ziel gemacht, die Studierenden der Fachschaften einzelner Fakultäten miteinander zu vernetzen. Dies gelingt ihnen und ebnet den Weg für viele, zuvor unmögliche, Projekte an der Hochschule Esslingen.

            Der studentische Verein betreibt an jedem Standort der Hochschule je ein Café und ein Lehrmittelreferat, welche von Studierenden eigenständig betreut und verwaltet werden. Damit auch das Studentische Leben nach den täglichen Vorlesungen nicht zu kurz kommt, veranstaltet CampusLeben mit den Studierenden aller Fachschaften Partys, Aktivitäten und kulturelle Events.</p>
      </div>
      <div class="mt-6 prose prose-indigo prose-lg text-gray-500 mx-auto">

        <figure>
          <img class="w-full rounded-lg" src="{{ asset('storage/images/csm_logo_campusleben.png') }}" alt="" width="1310" height="873">
        </figure>
    </div>
    </div>
  </div>
@endsection
