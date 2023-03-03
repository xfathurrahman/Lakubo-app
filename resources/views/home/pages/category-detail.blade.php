@extends('home.main')

@section('content')

    <div id="loading-background">
        <div id="loading-animation" data-animation-path="{{ asset('assets/json/loading-shop.json') }}"></div>
    </div>

    <div class="container py-24 bg-white text-center">
        Detail Category
        <img class="mx-auto" src="{{ asset('assets/images/app/game.jpg') }}" alt="">
    </div>
@endsection
