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

                    Olá {{ Auth::user()->name }}

                    <form method="POST" action="{{ route('createPost') }}">
                        @csrf

                        <div class="form-group">
                            <textarea class="form-control" name="body" id="new-post" rows="4" placeholder="Create your post"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Post</button>
                    </form>
                    <br>
                    <h3>Posts</h3>
                    @foreach ($posts as $post)
                        <div class="container">
                            <div class="font-weight-bold">{{$post->name}}</div>
                            <div style="padding-left:2em">{{$post->body}}</div>
                            <div style ="margin-bottom:1em" class="font-weight-light font-italic">{{$post->created_at}}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
