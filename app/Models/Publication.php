<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Publication extends Model
{
    protected $fillable = [
        'title',
        'authors',
        'slug',
        'excerpt',
        'content',
        'category_id',
        'activity_date',
        'image_path',
        'status',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'activity_date' => 'date',
        ];
    }

    public function scopePubliclyVisible(Builder $query): Builder
    {
        return $query
            ->where('status', 'published')
            ->where(function (Builder $query): void {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            });
    }

    public function images(): HasMany
    {
        return $this->hasMany(PublicationImage::class)->orderBy('position');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
