<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\User;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeStaticController extends Controller
{
    public function index()
    {
        return view('frontend.posts.index');
    }

    public function getSearchResults(Request $request)
    {
        $frontendPosts = Post::search($request->search)->paginate(20);

        $categories = Category::get();
        $tags = Tag::get();
        return view('frontend.posts.search', compact('frontendPosts', 'categories', 'tags'));
    }

    public function adminIndex()
    {
        return view('backend.app');
    }

    public function showPostForm($id = -1)
    {
        if ($id != -1) {
            $post = Post::find($id);

            $postId = $post->id;

            return view('frontend.posts.create', compact('postId'));
        }
        return view('frontend.posts.create');
    }



    public function showPost($slug)
    {
        $post = Post::where('slug', $slug)->first();

        if (!$post || $post->is_published == false) {
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
