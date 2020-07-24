<form method="POST" action="{{route('microposts.store')}}">
    @csrf
    <div class="form-group">
        <textarea id="content" name="content" class="form-control" rows="2"></textarea>
    </div>
    <input type="submit" class="btn btn-primary btn-block" value="Post">
</form>