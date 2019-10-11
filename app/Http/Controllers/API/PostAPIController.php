<?php

namespace App\Http\Controllers\API;

use App\Models\Post;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;

class PostAPIController extends Controller
{
    /**
     * Shows all posts.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllPosts()
    {
        return Datatables::of(Post::query())
            ->removeColumn('user_id')
            ->addColumn('created_by', function($tag) {
                return $post->getUsername();
            })
            ->addColumn('action', function ($tag) {
                $attr = '<div class="btn-group" role="group" aria-label="Second group">';
                $attr .= '<a href="javascript:void(0)" class="btn btn-sm btn-info" id="edit-tag" data-id="' . $tag->id . '"><i class="fa fa-edit"></i> Edit</a>';
                $attr .= '<a href="javascript:void(0)" class="btn btn-sm btn-danger" id="delete-tag" data-id="' . $tag->id . '"><i class="fa fa-trash"></i> Delete</a></div>';

                return $attr;
            })
            ->rawColumns(['created_by', 'action'])
            ->make(true);
    }

    /**
     * Get tag details.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTag(int $id)
    {
        $tag = Tag::findOrFail($id);

        return response($tag, 200);
    }

    /**
     * Creates a new tag.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function addTag(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'unique:tags']
        ]);
        
        $slug = str_slug($request->name);

        $user_id = auth('api')->user()->id;
        
        Tag::create([
            'name' => $request->name,
            'slug' => $slug,
            'user_id' => $user_id,
        ]);

        return response(null, 201);
    }

    /**
     * Edits tag details.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function editTag(Request $request, $id)
    {
        $tag = Tag::findOrFail($id);
        $this->validate($request, [
            'name' => ['required', 'unique:tags']
        ]);
        
        $slug = str_slug($request->name);

        $user_id = auth('api')->user()->id;
            
        $tag->update([
            'name' => $request->name,
            'slug' => $slug,
            'user_id' => $user_id,
        ]);

        return response(null, 200);
    }

    /**
     * Deletes tag.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteTag($id)
    {
        $tag = Tag::findOrFail($id);

        $tag->delete();

        return response(null, 200);
    }
}
