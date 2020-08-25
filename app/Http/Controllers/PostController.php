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

    public function listPosts()
    {
        $posts = DB::table('posts')
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->select('posts.*', 'users.name')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('home', ['posts' => $posts]);
    }

    public function deletePost($post_id)
    {
        $post = Post::find($post_id);
        $post->delete();

        return redirect()->route('home');
    }

    public function reorderPost($post_id)
    {
        dd($post_id);

    }
}
