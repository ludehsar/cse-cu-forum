<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeStaticController extends Controller
{
    public function index()
    {
        return view('frontend.posts.index');
    }

    public function adminIndex()
    {
        return view('backend.app');
    }

    public function showPostForm()
    {
        return view('frontend.posts.create');
    }

    public function showPost($slug)
    {
        $post = Post::where('slug', $slug)->first();

        if (!$post) {
            return redirect('/');
        }

        $postId = $post->id;
        $postTitle = $post->title;

        return view('frontend.posts.show', compact(['postId', 'postTitle']));
    }

    public function showProfile($username)
    {
        $user = User::where('username', $username)->first();

        if (!$user) {
            return redirect('/');
        }

        $userId = $user->id;
        $name = $user->name;

        return view('frontend.profile.profile', compact(['userId', 'name']));
    }

    public function showSettings()
    {
        $user = auth()->user();

        if (!$user) {
            return redirect('/');
        }

        $userId = $user->id;
        $name = $user->name;

        return view('frontend.profile.settings', compact(['userId', 'name']));
    }

    public function showContactForm()
    {
        return view('frontend.contact');
    }
}
