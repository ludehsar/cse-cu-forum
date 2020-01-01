<?php

namespace App\Http\Controllers\API;

use stdClass;
use App\Models\Post;
use App\Models\Profile;
use App\Models\Comment;
use App\Models\Contribution;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContributionAPIController extends Controller
{
    public function getUserPostContribution($postId)
    {
        $user = auth('api')->user();

        $contribution = Contribution::where('user_id', $user->id)->where('post_id', $postId)->first();

        if ($contribution) {
            return response($contribution->contribution_type, 200);
        }

        return response('', 200);
    }

    public function getUserCommentContribution($commentId)
    {
        $user = auth('api')->user();

        $contribution = Contribution::where('user_id', $user->id)->where('comment_id', $commentId)->first();

        if ($contribution) {
            return response($contribution->contribution_type, 200);
        }
        
        return response('', 200);
    }

    public function getPostContributionInfo($postId)
    {
        $contribution = Contribution::where('post_id', $postId)->get();

        $response = new stdClass();

        $response->helpfulness = $contribution->where('contribution_type', 'Helpful')->count();
        $response->unhelpfulness = $contribution->where('contribution_type', 'Unhelpful')->count();

        return response()->json($response);
    }

    public function getCommentContributionInfo($commentId)
    {
        $contribution = Contribution::where('comment_id', $commentId)->get();

        $response = new stdClass();

        $response->helpfulness = $contribution->where('contribution_type', 'Helpful')->count();
        $response->unhelpfulness = $contribution->where('contribution_type', 'Unhelpful')->count();

        return response()->json($response);
    }

    public function addContribution(Request $request)
    {
        $request->validate([
            'contribution_type' => 'required|in:Helpful,Unhelpful',
        ]);

        $user = auth('api')->user();
        $postId = null;
        $commentId = null;

        if (isset($request->post_id) && isset($request->comment_id)) return response(null, 422);
        else if (isset($request->post_id)) {
            $postId = $request->post_id;
            $contribution = Contribution::where('user_id', $user->id)->where('post_id', $postId)->first();

            $post = Post::findOrFail($postId);

            if ($user->id == $post->user_id) {
                return response(null, 422);
            }

            if ($contribution) {
                return response(null, 200);
            }
        }
        else if (isset($request->comment_id)) {
            $commentId = $request->comment_id;

            $contribution = Contribution::where('user_id', $user->id)->where('comment_id', $commentId)->first();

            $comment = Comment::findOrFail($commentId);

            if ($user->id == $comment->user_id) {
                return response(null, 422);
            }

            if ($contribution) {
                return response(null, 200);
            }
        }
        else return response(null, 422);

        Contribution::create([
            'post_id' => $postId,
            'comment_id' => $commentId,
            'user_id' => $user->id,
            'contribution_type' => $request->contribution_type
        ]);

        $contributions = Contribution::where('post_id', $postId)->where('comment_id', $commentId)->get();

        $totalHelpfulNess = $contributions->where('contribution_type', 'Helpful')->count();
        $totalUnhelpfulNess = $contributions->where('contribution_type', 'Unhelpful')->count();

        $totalContribution = $totalHelpfulNess - $totalUnhelpfulNess;
        
        if (isset($postId)) {
            $post = Post::findOrFail($postId);

            $posterProfile = Profile::firstOrNew(array('user_id' => $post->user_id));

            $posterProfile->user_id = $post->user_id;
            $posterProfile->save();
            
            $posterContributionPoint = $posterProfile->contribution_point - $post->total_contribution;

            $post->update([
                'total_contribution' => $totalContribution,
            ]);

            $posterContributionPoint += $post->total_contribution;

            $posterProfile->contribution_point = $posterContributionPoint;

            $posterProfile->save();
        }
        else {
            $comment = Comment::findOrFail($commentId);

            $commenterProfile = Profile::firstOrNew(array('user_id' => $comment->user_id));
            
            $commenterProfile->user_id = $comment->user_id;
            $commenterProfile->save();

            $commenterContributionPoint = $commenterProfile->contribution_point - $comment->total_contribution;

            $comment->update([
                'total_contribution' => $totalContribution,
            ]);

            $commenterContributionPoint += $comment->total_contribution;

            $commenterProfile->contribution_point = $commenterContributionPoint;

            $commenterProfile->save();
        }

        return response(null, 200);
    }
}
