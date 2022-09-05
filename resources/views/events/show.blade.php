@extends('layouts.app')

@section('content')
<div class="bg-white min-h-screen">
    <div id="app">
        <Event :event="{{ $event }}"></Event>
    </div>
</div>
@endsection
