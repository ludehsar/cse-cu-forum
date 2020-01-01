<?php

namespace App\Http\Controllers\API;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Reaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReactionAPIController extends Controller
{
    public function getUserPostReaction($postId)
    {
        $user = auth('api')->user();

        $reaction = Reaction::where('user_id', $user->id)->where('post_id', $postId)->first();

        if ($reaction) {
            return response($reaction->reaction_type, 200);
        }

        return response('', 200);
    }

    public function getUserCommentReaction($commentId)
    {
        $user = auth('api')->user();

        $reaction = Reaction::where('user_id', $user->id)->where('comment_id', $commentId)->first();

        if ($reaction) {
            return response($reaction->reaction_type, 200);
        }
        
        return response('', 200);
    }

    public function addReaction(Request $request)
    {
        $request->validate([
            'reaction_type' => 'required|in:Love,Wow,Haha,Angry',
        ]);

        $user = auth('api')->user();
        $postId = null;
        $commentId = null;

        if (isset($request->post_id) && isset($request->comment_id)) return response(null, 422);
        else if (isset($request->post_id)) {
            $postId = $request->post_id;
            $reaction = Reaction::where('user_id', $user->id)->where('post_id', $postId)->first();

            if ($reaction) {
                $reaction->delete();
            }
        }
        else if (isset($request->comment_id)) {
            $commentId = $request->comment_id;

            $reaction = Reaction::where('user_id', $user->id)->where('comment_id', $commentId)->first();

            if ($reaction) {
                $reaction->delete();
            }
        }
        else return response(null, 422);

        Reaction::create([
            'post_id' => $postId,
            'comment_id' => $commentId,
            'user_id' => $user->id,
            'reaction_type' => $request->reaction_type
        ]);

        $reactions = Reaction::where('post_id', $postId)->where('comment_id', $commentId)->get();

        $totalLove = $reactions->where('reaction_type', 'Love')->count();
        $totalWow = $reactions->where('reaction_type', 'Wow')->count();
        $totalHaha = $reactions->where('reaction_type', 'Haha')->count();
        $totalAngry = $reactions->where('reaction_type', 'Angry')->count();
        
        if (isset($postId)) {
            $post = Post::findOrFail($postId);

            $post->update([
                'total_love' => $totalLove,
                'total_wow' => $totalWow,
                'total_haha' => $totalHaha,
                'total_angry' => $totalAngry,
            ]);
        }
        else {
            $comment = Comment::findOrFail($commentId);

            $comment->update([
                'total_love' => $totalLove,
                'total_wow' => $totalWow,
                'total_haha' => $totalHaha,
                'total_angry' => $totalAngry,
            ]);
        }

        return response(null, 200);
    }
}
