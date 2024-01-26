@extends('layout')
@section('title', 'Login')
@section('content')
    <div class="container">

        <div class="mt-5">
            @if ($errors->any())
                <div class="col-12">
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">
                            {{ $error }}
                        </div>
                    @endforeach
                </div>
            @endIf

            @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif


            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        </div>


        <form action="{{ route('login.post') }}" method="POST" class="ms-auto me-auto mt-3" style="width: 500px">
            <!-- ADDING SECURITY FEATURE IN ORDER TO ADD TOKEN MAKE SURE THE INFOR IN COMING FROM YOUR SITE -->
            @csrf
            <div class="mb-3">
                <label class="form-label">Email address</label>
                <input type="email" class="form-control" name ="email">
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name ="password">
            </div>

            <div class="mb-3">
                <a href="{{ route('forget.password') }}">Forget Password</a>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <div class="ms-auto me-auto mt-3 d-flex" style="width: 500px">
            Are you new here? <a class="nav-link mx-2" href="{{ route('register') }}" style="color: blue">Sign up</a>

        </div>
    </div>
@endsection
