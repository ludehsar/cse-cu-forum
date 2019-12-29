<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;

class CategoryAPIController extends Controller
{
    /**
     * Shows all categories.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllCategories()
    {
        return Datatables::of(Category::query())
            ->removeColumn('user_id')
            ->addColumn('created_by', function($category) {
                return $category->user->name;
            })
            ->addColumn('action', function ($category) {
                $attr = '<div class="btn-group" role="group" aria-label="Second group">';
                $attr .= '<a href="javascript:void(0)" class="btn btn-sm btn-info" id="edit-category" data-id="' . $category->id . '"><i class="fa fa-edit"></i> Edit</a>';
                $attr .= '<a href="javascript:void(0)" class="btn btn-sm btn-danger" id="delete-category" data-id="' . $category->id . '"><i class="fa fa-trash"></i> Delete</a></div>';

                return $attr;
            })
            ->rawColumns(['created_by', 'action'])
            ->make(true);
    }

    /**
     * Gets category details.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCategory(int $id)
    {
        $category = Category::findOrFail($id);

        return response($category, 200);
    }

    /**
     * Adds a new category.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function addCategory(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'unique:categories']
        ]);
        
        $slug = str_slug($request->name);

        $user = auth('api')->user();

        if (!$user->is_admin) return response(null, 401);

        Category::create([
            'name' => $request->name,
            'slug' => $slug,
            'user_id' => $user->id,
        ]);

        return response(null, 200);
    }

    /**
     * Edits category.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function editCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $this->validate($request, [
            'name' => ['required', 'unique:categories']
        ]);
        
        $slug = str_slug($request->name);

        $user = auth('api')->user();

        if (!$user->is_admin) return response(null, 401);

        $category->update([
            'name' => $request->name,
            'slug' => $slug,
            'user_id' => $user->id,
        ]);

        return response(null, 200);
    }

    /**
     * Deletes category.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteCategory($id)
    {
        if (!(auth('api')->user()->is_admin)) return response(null, 401);

        $category = Category::findOrFail($id);

        $category->delete();

        return response(null, 200);
    }
}
