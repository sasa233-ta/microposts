@extends('layouts.app')

@section('content')
@if (Auth::check())
        <div class="row">
            <aside class="col-sm-4">
                {{-- ユーザ情報 --}}
                @include('users.card')
            </aside>
            <div class="col-sm-8">
                {{-- 投稿フォーム --}}
                @include('microposts.form')
                {{-- 投稿一覧 --}}
                @include('microposts.microposts')
            </div>
        </div>
    @else
    <div class="center jumbotron">
        <div class="text-center">
            <h1>Welcome to the Microposts</h1>
            <a class="btn btn-lg btn-primary" href="{{ route('signup.get') }}">Sign up now!</a>
        </div>
    </div>
    @endif
@endsection