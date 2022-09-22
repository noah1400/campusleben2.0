@extends("layouts.app")

@section("content")
<div class="relative bg-white pt-16 pb-20 px-4 sm:px-6 lg:pt-24 lg:pb-28 lg:px-8 min-h-screen">
    <div class="absolute inset-0">
      <div class="bg-white h-1/3 sm:h-2/3"></div>
    </div>
    <div class="relative max-w-7xl mx-auto">
      <div class="text-center">
        <h2 class="text-3xl tracking-tight font-extrabold text-gray-900 sm:text-4xl">Willkommen!</h2>
        <h2 class="text-3xl tracking-tight font-extrabold text-gray-900 sm:text-4xl">Hier findet ihr alles was das Studentenherz begehrt.</h2>
        <h2 class="text-3xl tracking-tight font-extrabold text-gray-900 sm:text-4xl"> #Campuswillleben</h2>
      </div>
      <div class="max-w-7xl mx-auto p-5">
        <img style="max-height: 250px" class="mx-auto" src="{{ asset('storage/images/csm_logo_campusleben.png') }}" alt="Aerial view of city buildings with a clear sky">
      </div>
    </div>
  </div>
@endsection
