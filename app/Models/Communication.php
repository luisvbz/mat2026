<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Communication extends Model
{
    use HasFactory;

      protected $fillable = [
        'title',
        'content',
        'category',
        'published_at',
        'author_id',
        'author_name',
        'is_published',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_published' => 'boolean',
    ];


    public function attachments()
    {
        return $this->hasMany(CommunicationAttachment::class, 'communication_id');
    }

    public function reads()
    {
        return $this->hasMany(CommunicationRead::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Get the count of users who have read this communication
     */
    public function getReadCountAttribute()
    {
        return $this->reads()->count();
    }

    /**
     * Check if a specific parent user has read this communication
     */
    public function isReadBy($parentUserId)
    {
        return $this->reads()
            ->where('parent_user_id', $parentUserId)
            ->exists();
    }

    /**
     * Get percentage of parent users who have read this
     */
    public function getReadPercentageAttribute()
    {
        $totalParents = \App\Models\ParentUser::where('is_active', true)->count();
        
        if ($totalParents === 0) {
            return 0;
        }

        return round(($this->read_count / $totalParents) * 100, 2);
    }
}
