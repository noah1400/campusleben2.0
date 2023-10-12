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
      <h1>
        <span class="mt-2 block text-3xl text-center leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">Wer sind wir?</span>
      </h1>
      <p class="mt-8 text-xl text-gray-500 leading-8">Seit dem Jahr 2011 nimmt CampusLeben viele Aufgaben innerhalb der Hochschule mit und für die Studierenden nach dem Motto "Mit Freu(n)den etwas bewegen" wahr. CampusLeben hat es sich zum primären Ziel gemacht, die Studierenden der Fachschaften einzelner Fakultäten miteinander zu vernetzen. </p>
      <h1>
        <span class="mt-2 block text-3xl text-center leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">Was macht CampusLeben?</span>
      </h1>
      <p class="mt-8 text-xl text-gray-500 leading-8">CampusLeben organsiert Kulturveranstaltungen, Partys, Ausflüge, Kneipentouren, (Bierpong-)Turniere, Spielabende, (Wein-)Wanderungen, Wasen, also alles, was das Studentenherz begehrt. Im Archiv (hier Link zum Archiv) kannst du die die Veranstaltungen der letzten Semester anschauen. Wir sind immer offen für neue Ideen, wie man Studierende am Campus vernetzen kann und Ihnen Spaß außerhalb der Vorlesungsräume bringen kann und freuen uns auf jede/n, der mitmachen möchte.</p>
      <p class="mt-8 text-xl text-gray-500 leading-8">CampusLeben betreibt auch das Hochschulcafé HZE (Instagram: <a href="https://www.instagram.com/hzecafe/" alt="hzecafe">hzecafe</a>) am Campus Flandernstraße sowie das Café Einstein
        (Instagram: <a href="https://www.instagram.com/cafeeinsteinhs/" alt="cafeeinsteinhs"> cafeeinsteinhs</a>) in der Stadtmitte, wo regelmäßig Kinoabende, Kneipenabende sowie Spielabende stattfinden. </p>
      <p class="mt-8 text-xl text-gray-500 leading-8">Zudem gibt es an den Standorten Flandernstraße und Stadtmitte jeweils ein Lehrmittelreferat (LMR) sowie eine Fahrradwerkstatt. In den LMR’s werden Büroartikel, Taschenrechner sowie Bücher zu günstigen Preisen verkauft.</p>
      <h1>
        <span class="mt-2 block text-3xl text-center leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">Wie kann ich mitmachen?</span>
      </h1>
      <p class="mt-8 text-xl text-gray-500 leading-8">Unsere Meetings finden jede Woche dienstags um 19 Uhr im HZE-Café (F01.-110) am Campus Flandernstraße statt. Du kannst einfach vorbeikommen und mitmachen. Wenn du dir noch unsicher bist, kannst du uns zuerst auf Instagram schreiben
        (<a href="https://www.instagram.com/campus_leben/" alt="campus_leben"> campus_leben</a>) oder per Mail campusleben@hs-esslingen.de . </p>
      <p class="mt-8 text-xl text-gray-500 leading-8">Du möchtest dich in den Cafés oder LMR’s einbringen? Wir suchen stets neue Leute, die uns unterstützen. Schreib uns!</p>
    </div>
    <div class="mt-6 prose prose-indigo prose-lg text-gray-500 mx-auto">

      <figure>
        <img class="w-full rounded-lg" src="{{ asset('storage/images/csm_logo_campusleben.png') }}" alt="" width="1310" height="873">
      </figure>
    </div>
  </div>
</div>
@endsection