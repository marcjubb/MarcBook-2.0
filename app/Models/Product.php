<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;


class Product extends Model
{

    use HasFactory;

    protected $with = ['categories'];
    protected $fillable = ['body','title','category_id','price','slug','image'];
    protected $table = 'products';
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
    public function WishlistItem(): BelongsToMany
    {
        return $this->BelongsToMany(WishlistItem::class);
    }
    public function basketItems(): BelongsToMany
    {
        return $this->BelongsToMany(BasketItem::class);
    }
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('score');
    }
    public function categories(): BelongsToMany
    {
        return $this->BelongsToMany(Category::class, 'category_product',
            'product_id','category_id');
    }
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

}
