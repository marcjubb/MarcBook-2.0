<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;


class Post extends Model
{

    use HasFactory;

    protected $with = ['author','categories','comments'];
    protected $fillable = ['user_id','body','title','category_id','slug','image'];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, fn($query, $search) =>
        $query->where(fn($query) =>
        $query->where('title', 'like', '%' . $search . '%')
            ->orWhere('body', 'like', '%' . $search . '%')
        )
        );
        $query->when($filters['author'] ?? false, fn($query, $author) =>
        $query->whereHas('author'[], fn ($query) =>
        $query->where('username', $author)
        )
        );
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function categories(): BelongsToMany
    {
        return $this->BelongsToMany(Category::class, 'category_post',
            'post_id','category_id');
    }
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

}
