@extends('layout')
@section('title', 'Home Page')
@section('content')

    @auth
    <div class="container" >
    <div class="ms-auto me-auto mt-3" style="width: 500px" >
        Welcome {{ auth()->user()->name }}

        <div class="">
            <button><a class="nav-link" href="{{route('profile')}}">Go to your profile</a></button>
        </div>
        </div>
        </div>
    @endauth
z
    @guest
    <div class="container">
    <div class="ms-auto me-auto mt-3" style="width: 500px">
        <div class="">
            <h1>Welcome Guest</h1>
        </div>
        <div class="">
            <button><a class="nav-link" href="{{route('login')}}">Login</a></button>
        </div>
        </div>
        </div>
    @endguest

@endsection
