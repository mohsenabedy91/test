<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'isbn',
        'title',
        'description',
    ];

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'book_author');
    }

    public function reviews()
    {
        return $this->hasMany(BookReview::class);
    }

    public function scopeTitle($query, $title)
    {
        if ($title) {
            return $query->where('title', 'like', '%' . $title . '%');
        }

        return $query;
    }

    public function scopeAuthor($query, $authorId)
    {
        if ($authorId) {
            $authorId = explode(',', $authorId);
            return $query->whereHas('authors', function ($q) use ($authorId) {
                $q->whereIn('id', $authorId);
            });
        }

        return $query;
    }
}
