@extends('layouts.app')

@section('content')
    <div class="text-center">
        <h1>Log in</h1>
    </div>

    <div class="row">
        <div class="col-sm-6 offset-sm-3">
            <form method="POST" action="{{route('login.post')}}" accept-charset="UTF-8">
                @csrf
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input class="form-control" id="email" name="email" type="email" value="{{ old('email')}}">
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input class="form-control" id="password" name="password" type="password">
                </div>
                <input class="btn btn-primary btn-block" type="submit" value="Log in">
            </form>

            {{-- ユーザ登録ページへのリンク --}}
            <p class="mt-2">New user? <a href="{{route('signup.get')}}">Sign up now!</a></p>
        </div>
    </div>
@endsection