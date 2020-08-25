@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (\Session::has('success'))
                    <div class="alert alert-success">
                        <ul>
                            <li>{!! \Session::get('success') !!}</li>
                        </ul>
                    </div>
                    @endif
 
                    <h4 class="mb-4">Olá {{ Auth::user()->name }}</h4>

                    <form method="POST" action="{{ route('createPost') }}">
                        @csrf
                        <div class="form-group">
                            <textarea class="form-control" name="body" id="new-post" rows="4" placeholder="Create your post"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary float-right">Create Post</button>
                    </form>
                    <br>

                    <h3>Posts</h3>
                    @if ($postsCount == 0)
                        <h5 class="container">There are no posts...</h5>
                    @endif
                    
                    @foreach ($posts as $post)
                        <div class="container">
                            @if (Auth::id() == $post->user_id)
                            <div class="float-right">
                                <form action="{{ action('PostController@moveDownOrder', $post->id) }}" method="POST">
                                    @csrf @method('patch')
                                    @if ($post->order != 1)
                                        <button type="submit" class="btn btn-default"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-down-square-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 5a.5.5 0 0 0-1 0v4.793L5.354 7.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 9.793V5z"/>
                                        </svg></button>
                                    @endif
                                </form>
                                <form action="{{ action('PostController@moveUpOrder', $post->id) }}" method="POST">
                                    @csrf @method('patch')
                                    @if ($post->order != $postsCount)
                                    <button type="submit" class="btn btn-default"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-up-square-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm3.354 8.354a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 6.207V11a.5.5 0 0 1-1 0V6.207L5.354 8.354z"/>
                                    </svg></button>
                                    @endif
                                    
                                </form>
                            </div>
                            @endif

                            <div class="font-weight-bold">{{$post->name}}</div>
                            <div style="padding-left:2em">{{$post->body}}</div>
                            <div class="font-weight-light font-italic">{{$post->created_at}}</div>

                            @if (Auth::id() == $post->user_id)
                                <form action="{{ action('PostController@deletePost', $post->id) }}" method="POST" class="inline">
                                    @csrf @method('delete')
                                    <button type="submit" class="btn btn-danger btn-sm mb-4">Remove Post</button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
