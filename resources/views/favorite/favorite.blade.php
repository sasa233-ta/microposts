@if ($favorite->is_favorite($micropost->id))
    {{-- いいね解除のフォーム --}}
    <form method="POST" action="{{route('favorities.unfavorite',[$micropost->id])}}" >
    @csrf
        <input type="submit" class="btn btn-danger btn-block" value="Unfavorite">
        <input type="hidden" name="_method" value="DELETE">
    </form>
@else
    {{-- いいねボタンのフォーム --}}
    <form method="POST" action="{{route('favorities.favorite',[$micropost->id])}}" >
    @csrf
        <input type="submit" class="btn btn-primary btn-block" value="favorite">
    </form>
@endif