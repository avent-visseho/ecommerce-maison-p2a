<?php

namespace App\Models;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    use HasFactory, SoftDeletes, Translatable;

    /**
     * Les attributs traduisibles.
     *
     * @var array
     */
    protected $translatable = [
        'title',
        'excerpt',
        'content',
        'meta_title',
        'meta_description',
    ];

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'images',
        'author_id',
        'blog_category_id',
        'status',
        'published_at',
        'scheduled_at',
        'views',
        'is_featured',
        'allow_comments',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'images' => 'array',
        'published_at' => 'datetime',
        'scheduled_at' => 'datetime',
        'is_featured' => 'boolean',
        'allow_comments' => 'boolean',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });
    }

    /**
     * Get the author that owns the blog post.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get the category that owns the blog post.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    /**
     * Get the tags for the blog post.
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(BlogTag::class, 'blog_post_tag');
    }

    /**
     * Get the comments for the blog post.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(BlogComment::class)->whereNull('parent_id');
    }

    /**
     * Get all comments (including replies).
     */
    public function allComments(): HasMany
    {
        return $this->hasMany(BlogComment::class);
    }

    /**
     * Get approved comments only.
     */
    public function approvedComments(): HasMany
    {
        return $this->hasMany(BlogComment::class)
            ->where('status', 'approved')
            ->whereNull('parent_id')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Scope a query to only include published posts.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->where('published_at', '<=', now());
    }

    /**
     * Scope a query to only include draft posts.
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Scope a query to only include scheduled posts.
     */
    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled')
            ->where('scheduled_at', '>', now());
    }

    /**
     * Scope a query to only include featured posts.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Check if the post is published.
     */
    public function isPublished(): bool
    {
        return $this->status === 'published' && $this->published_at <= now();
    }

    /**
     * Check if the post is draft.
     */
    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    /**
     * Check if the post is scheduled.
     */
    public function isScheduled(): bool
    {
        return $this->status === 'scheduled' && $this->scheduled_at > now();
    }

    /**
     * Increment post views.
     */
    public function incrementViews()
    {
        $this->increment('views');
    }

    /**
     * Get reading time in minutes.
     */
    public function getReadingTimeAttribute(): int
    {
        $words = str_word_count(strip_tags($this->content));
        return max(1, ceil($words / 200));
    }

    /**
     * Get related posts based on tags.
     */
    public function relatedPosts($limit = 3)
    {
        $tagIds = $this->tags->pluck('id');

        return static::published()
            ->where('id', '!=', $this->id)
            ->whereHas('tags', function ($query) use ($tagIds) {
                $query->whereIn('blog_tags.id', $tagIds);
            })
            ->withCount(['tags' => function ($query) use ($tagIds) {
                $query->whereIn('blog_tags.id', $tagIds);
            }])
            ->orderByDesc('tags_count')
            ->orderByDesc('views')
            ->limit($limit)
            ->get();
    }
}
