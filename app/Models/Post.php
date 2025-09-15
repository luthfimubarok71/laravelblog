<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'slug', 'author_id', 'category_id', 'body'];
    // protected $guarded = ['id'];
    protected $with = ['category', 'author'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    #[Scope]
    protected function filter(Builder $query, array $filters): void
    {
        $query->when($filters['keyword'] ?? false, function ($query, $filters) {
            return $query->where('title', 'like', '%' . $filters . '%');
        });

        $query->when($filters['category'] ?? false, function ($query, $filters) {
            return $query->whereHas('category', fn(Builder $query) =>
            $query->where('slug', $filters));
        });

        $query->when($filters['author'] ?? false, function ($query, $filters) {
            return $query->whereHas('author', fn(Builder $query) =>
            $query->where('username', $filters));
        });
    }
}
