<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posting extends Model
{
    use HasFactory , HasUuids;
    protected $table = 'postings';
    protected $guarded=[
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function likes()
    {
        return $this->hasMany(Like::class, 'post_id' );
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class, 'post_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class , 'post_id');
    }
}
