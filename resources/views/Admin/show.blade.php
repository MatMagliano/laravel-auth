@extends('layouts.app')
@section('content')
  <table class="table">
  <thead>
    <tr>
      <th scope="col">user_id</th>
      <th scope="col">title</th>
      <th scope="col">body</th>
      <th scope="col">slug</th>
      <th scope="col">tag</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">{{$post->id}}</th>
      <td>{{$post->title}}</td>
      <td>{{$post->body}}</td>
      <td>{{$post->slug}}</td>
      @foreach ($post->tags as $tag)
        <td>{{$tag->name}}</td>         
      @endforeach
      <td><a class="btn btn-primary" href="{{route('admin.posts.index', $post)}}">Home</a></td>
    </tr>
  </tbody>
      
</table>
<img src="{{asset('storage/' . $post->image)}}" alt="">
<div class="comments">
  @forelse ($post->comments as $comment)
    <ul class="list-group">
      <li class="list-group-item active">Title Comment: {{$comment->title}}</li>
      <li class="list-group-item">{{$comment->body}}</li>
      <li class="list-group-item">{{$comment->name}}</li>
      <li class="list-group-item">{{$comment->email}}</li>
    </ul>    
  @empty
      <h5>non ci sono commenti</h5>
  @endforelse
</div>
<div>
  <h3>ADD COMMENT</h3>
  <form action="{{route('comment.store')}}" method="post">
      @csrf
      @method('POST')
      <div class="form-group">
        <label for="title">Title</label>
        <input class="form-control" type="text" name="title">
      </div>
      <div class="form-group">
        <label for="name">name</label>
        <input class="form-control" type="text" name="name">
      </div>
      <div class="form-group">
        <label for="email">email</label>
        <input class="form-control" type="text" name="email">
      </div>
      <div class="form-group">
        <label for="body">body</label>
        <textarea class="form-control" name="body" id="body" cols="30" rows="10"></textarea>
        <input type="hidden" name="post_id" value="{{$post->id}}">
        <button class="btn btn-success" type="submit">Salva</button>
      </div>
    </form>
</div>

@endsection