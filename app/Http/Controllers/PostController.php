<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use DB;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function createPost(Request $request)
    {
        $post = new Post();
        $post->body = $request->body;
        $request->user()->posts()->save($post);

        return redirect()->route('home')->with('success', 'Post successfully created!');
    }

    public function posts()
    {
        $posts = DB::table('posts')
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->select('posts.*', 'users.name')
            ->orderBy('created_at', 'desc')
            ->get();

        //$posts = Post::orderBy('created_at', 'desc')->get();
        return view('home', ['posts' => $posts]);
    }

    public function getUser($user_id)
    {
        return User::find($user_id);
    }
}
