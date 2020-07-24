@extends('layouts.app')

@section('content')
    <div class="text-center">
        <h1>Sign up</h1>
    </div>

    <div class="row">
        <div class="col-sm-6 offset-sm-3">
            <form method="POST" action="{{ route('signup.post') }}" accept-charset="UTF-8">
            @csrf
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input class="form-control" id="name" name="name" type="text" value="{{ old('name')}}">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input class="form-control" id="email" name="email" type="email" value="{{ old('email')}}">                    
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input class="form-control" id="password" name="password" type="password">
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirmation:</label>
                    <input class="form-control" id="password_confirmation" name="password_confirmation" type="password">
                </div>
                <input class="btn btn-primary btn-block" type="submit" value="Sign up">
            </form>
        </div>
    </div>
@endsection