@extends('layout')
@section('content')
    <main>
        <div class="ms-auto me-auto mt-5" style="width: 500px">
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
            <p>We will be sending a link to your email, use the link to reset your password.</p>
            <form action="{{ route('forget.password.post') }}" method="POST">
                <!-- ADDING SECURITY FEATURE IN ORDER TO ADD TOKEN MAKE SURE THE INFOR IN COMING FROM YOUR SITE -->
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email address</label>
                    <input type="email" class="form-control" name ="email">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </main>
@endsection
