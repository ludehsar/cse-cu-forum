<?php

namespace App\Models;

use DB;
use App\Models\Tag;
use App\Models\User;
use App\Models\Category;
use App\Models\Comment;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use Searchable;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'subtitle', 'category_id', 'user_id', 'slug', 'description', 'is_published', 'total_contribution', 'total_love', 'total_wow', 'total_haha', 'total_angry'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag_bridges')->withTimestamps();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function delete()    
    {
        DB::transaction(function() 
        {
            $this->comments()->delete();
            parent::delete();
        });
    }

    public function shouldBeSearchable()
    {
        return $this->is_published && $this->user->is_verified && !$this->user->is_blocked;
    }

    public function toSearchableArray()
    {
        $array = $this->toArray();

        $array['category_name'] = $this->category->name;
        $array['category_slug'] = $this->category->slug;

        $array['username'] = $this->user['username'];
        $array['user_profile_picture_url'] = $this->user['profile_picture_url'];
        $array['user_full_name'] = $this->user['name'];

        $array['total_comments'] = $this->comments->count();

        $array['tags'] = $this->tags->map(function ($tag) {
            return $tag['name'];
        })->toArray();

        return $array;
    }
}
