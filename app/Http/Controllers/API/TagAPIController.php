<?php

namespace App\Http\Controllers\API;

use App\Models\Tag;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;

class TagAPIController extends Controller
{
    /**
     * Shows all tags.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllTags()
    {
        return Datatables::of(Tag::query())
            ->removeColumn('user_id')
            ->addColumn('created_by', function($tag) {
                return $tag->user->name;
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

        $user = auth('api')->user();

        if ($user->is_verified) {
            Tag::create([
                'name' => $request->name,
                'slug' => $slug,
                'user_id' => $user->id,
            ]);
        }

        return response(null, 200);
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

        $user = auth('api')->user();

        if (!$user->is_admin) return response(null, 401);
            
        $tag->update([
            'name' => $request->name,
            'slug' => $slug,
            'user_id' => $user->id,
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
        if (!(auth('api')->user()->is_admin)) return response(null, 401);
        
        $tag = Tag::findOrFail($id);

        $tag->posts()->detach();

        $tag->delete();

        return response(null, 200);
    }
}
