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
            ->addColumn('action', function ($category) {
                $attr = '<div class="btn-group" role="group" aria-label="Second group">';
                $attr .= '<a href="javascript:void(0)" class="btn btn-sm btn-info" id="edit-category" data-id="' . $category->id . '"><i class="fa fa-edit"></i> Edit</a>';
                $attr .= '<a href="javascript:void(0)" class="btn btn-sm btn-danger" id="delete-category" data-id="' . $category->id . '"><i class="fa fa-trash"></i> Delete</a></div>';

                return $attr;
            })
            ->rawColumns(['action'])
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

    public function addCategory(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'unique:categories']
        ]);
        
        $slug = str_slug($request->name);
            
        Category::create([
            'name' => $request->name,
            'slug' => $slug
        ]);

        return response(null, 201);
    }

    public function editCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $this->validate($request, [
            'name' => ['required', 'unique:categories']
        ]);
        
        $slug = str_slug($request->name);
            
        $category->update([
            'name' => $request->name,
            'slug' => $slug
        ]);

        return response(null, 200);
    }

    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);

        $category->delete();

        return response(null, 200);
    }
}
