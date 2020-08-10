@if (Auth::user()->is_favorite($micropost->id))
    {{-- いいね解除のフォーム --}}
    <form method="POST" action="{{route('favorities.unfavorite',[$micropost->id])}}" >
    @csrf
        <input type="submit" class="btn btn-danger btn-block btn-sm" value="Unfavorite">
        <input type="hidden" name="_method" value="DELETE">
    </form>
@else
    {{-- いいねボタンのフォーム --}}
    <form method="POST" action="{{route('favorities.favorite',[$micropost->id])}}" >
    @csrf
        <input type="submit" class="btn btn-success btn-block btn-sm" value="favorite">
    </form>
@endif