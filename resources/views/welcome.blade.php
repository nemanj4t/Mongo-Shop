@extends('layouts.app')

@section('content')
    <div class="container">
    @auth
        <index-new user="auth"></index-new>
        <index-recommendation user="auth"></index-recommendation>
        <index-good-price user="auth"></index-good-price>
    @else
        <index-new user="guest"></index-new>
        <index-recommendation user="guest"></index-recommendation>
        <index-good-price user="guest"></index-good-price>
    @endauth
    </div>
@endsection
