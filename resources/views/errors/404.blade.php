@extends('errors::minimal')

@section('title', 'Nicht gefunden')
@section('code', '404')
@section('tip', 'Bitte überprüfen Sie die URL in der Adressleiste und versuchen Sie es erneut.')
@section('message', 'Die angeforderte Seite wurde nicht gefunden.')
@section('extra')
    <div class="mt-10 flex space-x-3 sm:border-l sm:border-transparent sm:pl-6">
        <a href="{{ route('home') }}"
            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Startseite </a>
        <a href="{{ route('contact') }}"
            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Kontakt </a>
    </div>
@endsection
