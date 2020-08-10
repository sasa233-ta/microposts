<header class="mb-4">
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        {{-- トップページへのリンク --}}
        <a class="navbar-brand" href="/">Microposts</a>

        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#nav-bar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="nav-bar">
            <ul class="navbar-nav mr-auto"></ul>
            <ul class="navbar-nav">
            @if (Auth::check())
            {{-- ユーザ一覧ページへのリンク --}}
                <li class="nav-item"><a class="nav-link" href="{{route('users.index')}}">Users</a></li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">{{ Auth::user()->name }}</a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        {{-- ユーザ詳細ページへのリンク --}}
                        <li class="dropdown-item"><a href="{{route('users.show',['user' => Auth::id()])}}">My profile</a></li>
                        <li class="dropdown-item"><a href="{{ route('users.favorities', ['id' => $user->id]) }}">favorities</a></li>
                        <li class="dropdown-divider"></li>
                        {{-- ログアウトへのリンク --}}
                        <li class="dropdown-item"><a href="{{route('logout.get')}}">Logout</a></li>
                    </ul>
                </li>
                @else
                {{-- ユーザ登録ページへのリンク --}}
                <li class="nav-item"><a href="{{ route('signup.get') }}" class="nav-link">Signup</a></li>
                {{-- ログインページへのリンク --}}
                <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Login</a></li>
                @endif
            </ul>
        </div>
    </nav>
</header>