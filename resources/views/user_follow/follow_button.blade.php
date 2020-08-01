@if (Auth::id() != $user->id)
    @if (Auth::user()->is_following($user->id))
        {{-- アンフォローボタンのフォーム --}}
        <form method="POST" action="{{route('user.unfollow',$user->id)}}" >
        @csrf
            <input type="submit" class="btn btn-danger btn-block" value="unfollow">
            <input type="hidden" name="_method" value="DELETE">
        </form>
    @else
        {{-- フォローボタンのフォーム --}}
        <form method="POST" action="{{route('user.follow',$user->id)}}" >
        @csrf
            <input type="submit" class="btn btn-primary btn-block" value="follow">
        </form>
    @endif
@endif