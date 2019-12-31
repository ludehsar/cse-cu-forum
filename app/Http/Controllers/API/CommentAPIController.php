<?php

namespace App\Http\Controllers\API;

use App\MOdels\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentAPIController extends Controller
{
    public function getAllComments()
    {
        // ...
    }

    public function getCommentsOfPost($id)
    {
        $comments = Post::findOrFail($id)->comments()->oldest()->where('parent_id', null)->get();

        return response($comments, 200);
    }

    public function getRepliesOfComment($id)
    {
        $comments = Comment::findOrFail($id)->replies()->oldest()->get();

        return response($comments, 200);
    }

    public function getComment($id)
    {
        $comment = Comment::findOrFail($id);

        return response($comment, 200);
    }

    public function addComment(Request $request)
    {
        $this->validate($request, [
            'post_id' => ['required', 'exists:posts,id'],
            'description' => ['required'],
        ]);

        $user = auth('api')->user();
        $parentId = null;
        if (isset($request->parent_id)) $parentId = Comment::findOrFail($request->parent_id)->id;

        Comment::create([
            'user_id' => $user->id,
            'post_id' => $request->post_id,
            'parent_id' => $parentId,
            'description' => $request->description
        ]);

        return response(null, 201);
    }

    public function editComment($id, Request $request)
    {
        $this->validate($request, [
            'description' => ['required'],
        ]);

        $comment = Comment::findOrFail($id);

        if (auth('api')->user()->is_admin || auth('api')->user()->id == $comment->user_id) {
            $comment->update([
                'description' => $request->description
            ]);
        }

        return response(null, 200);
    }

    public function deleteComment($id)
    {
        $comment = Comment::findOrFail($id);

        if (auth('api')->user()->is_admin || auth('api')->user()->id == $comment->user_id) {
            $comment->delete();
        }

        return response(null, 200);
    }
}
