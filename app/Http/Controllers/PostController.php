<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function createPost(Request $request)
    {
        $myPosts = Post::where('user_id', '=', Auth::id());

        $post = new Post();
        $post->body = $request->body;

        if ($myPosts->count() == 0) {
            $post->order = 1;
        } else {
            $lastPost = $myPosts->orderBy('order', 'desc')->first();
            $post->order = $lastPost->order + 1;
        }

        $request->user()->posts()->save($post);

        return redirect()->route('home')->with('success', 'Post successfully created!');
    }

    public function listPosts()
    {
        $posts = DB::table('posts')
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->select('posts.*', 'users.name')
        //->orderBy('created_at', 'desc')
            ->orderBy('order', 'desc')
            ->get();

        $postsCount = Post::where('user_id', '=', Auth::id())->count();

        return view('home', ['posts' => $posts, 'postsCount' => $postsCount]);
    }

    public function deletePost($post_id)
    {
        $post = Post::find($post_id);

        $myPosts = Post::where('user_id', '=', Auth::id());
        $myPostsCount = $myPosts->count();

        $postsToRemove = $myPosts->where('order', '>', $post->order)->get();

        if ($post->order != $myPostsCount && $postsToRemove->count() != 0) {
            foreach ($postsToRemove as $p) {
                $p->order--;
                $p->save();
            }
        }

        $post->delete();

        return redirect()->route('home');
    }

    public function moveUpOrder($post_id)
    {
        $myPosts = Post::where('user_id', '=', Auth::id());

        $post = Post::find($post_id);
        $number = $post->order;

        $postToOrder = $myPosts->where('order', $number + 1)->first();
        $postToOrder->order--;
        $postToOrder->save();

        $post->order++;
        $post->save();

        return redirect()->route('home');
    }

    public function moveDownOrder($post_id)
    {
        $myPosts = Post::where('user_id', '=', Auth::id());

        $post = Post::find($post_id);
        $number = $post->order;

        $postToOrder = $myPosts->where('order', $number - 1)->first();
        $postToOrder->order++;
        $postToOrder->save();

        $post->order--;
        $post->save();

        return redirect()->route('home');
    }
}
