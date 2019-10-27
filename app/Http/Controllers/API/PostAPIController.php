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
            ->removeColumn('category_id')
            ->removeColumn('description')
            ->removeColumn('subtitle')
            ->removeColumn('slug')
            ->removeColumn('is_published')
            ->removeColumn('total_contribution')
            ->removeColumn('total_love')
            ->removeColumn('total_wow')
            ->removeColumn('total_haha')
            ->removeColumn('total_angry')
            ->addColumn('created_by', function($post) {
                return $post->user->name;
            })
            ->addColumn('category', function($post) {
                return $post->category->name;
            })
            ->addColumn('status', function($post) {
                if ($post->is_published) return '<span style="color: green">Published</span>';
                return '<span style="color: red">Not Published</span>';
            })
            ->addColumn('action', function ($post) {
                $attr = '<div class="btn-group" role="group" aria-label="Second group">';
                $attr .= '<a href="javascript:void(0)" class="btn btn-sm btn-primary" id="view-post" data-id="' . $post->id . '"><i class="fa fa-eye"></i> View</a>';
                $attr .= '<a href="javascript:void(0)" class="btn btn-sm btn-info" id="edit-post" data-id="' . $post->id . '"><i class="fa fa-edit"></i> Edit</a>';
                $attr .= '<a href="javascript:void(0)" class="btn btn-sm btn-danger" id="delete-post" data-id="' . $post->id . '"><i class="fa fa-trash"></i> Delete</a></div>';

                return $attr;
            })
            ->rawColumns(['created_by', 'category', 'status', 'action'])
            ->make(true);
    }

    /**
     * Get post details.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPost(int $id)
    {
        $post = Post::findOrFail($id);

        return response($post, 200);
    }

    /**
     * Get post tags.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPostTags(int $id)
    {
        $tags = Post::findOrFail($id)->tags();

        return response($tags->get(), 200);
    }

    /**
     * Creates a new post.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function addPost(Request $request)
    {
        $this->validate($request, [
            'title' => ['required'],
            'subtitle' => ['required'],
            'category' => ['required', 'exists:categories,id'],
            'tags' => ['required', 'array'],
            'tags[*]' => ['exists:tags,id'],
            'description' => ['required'],
        ]);

        $isPublished = $request->has('publish') && $request->publish == true;
        
        $slug = $this->createSlug($request->title);

        $user_id = auth('api')->user()->id;
        
        Post::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'category_id' => $request->category,
            'user_id' => $user_id,
            'slug' => $slug,
            'description' => $request->description,
            'is_published' => $isPublished,
        ]);

        $post = Post::where('slug', $slug)->first();

        $post->tags()->sync($request->tags);

        return response(null, 201);
    }

    /**
     * Edits post details.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function editPost(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        
        $this->validate($request, [
            'title' => ['required'],
            'subtitle' => ['required'],
            'category' => ['required', 'exists:categories,id'],
            'tags' => ['required', 'array'],
            'tags[*]' => ['exists:tags,id'],
            'description' => ['required'],
        ]);

        $isPublished = $request->has('publish') && $request->publish == true;
        
        $slug = $this->createSlug($request->title, $id);

        $post->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'category_id' => $request->category,
            'slug' => $slug,
            'description' => $request->description,
            'is_published' => $isPublished,
        ]);

        $post->tags()->sync($request->tags);

        return response(null, 200);
    }

    /**
     * Deletes post.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deletePost($id)
    {
        $post = Post::findOrFail($id);

        $post->tags()->detach();

        $post->delete();

        return response(null, 200);
    }

    /**
     * @param $title
     * @param int $id
     * @return string
     * @throws \Exception
     */
    public function createSlug($title, $id = 0)
    {
        // Normalize the title
        $slug = str_slug($title);
        
        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = $this->getRelatedSlugs($slug, $id);
        
        // If we haven't used it before then we are all good.
        if (! $allSlugs->contains('slug', $slug)){
            return $slug;
        }
        
        // Just append numbers like a savage until we find not used.
        for ($i = 1;; $i++) {
            $newSlug = $slug.'-'.$i;
            if (! $allSlugs->contains('slug', $newSlug)) {
                return $newSlug;
            }
        }

        throw new \Exception('Can not create a unique slug');
    }

    protected function getRelatedSlugs($slug, $id = 0)
    {
        return Post::select('slug')->where('slug', 'like', $slug.'%')
            ->where('id', '<>', $id)
            ->get();
    }
}
