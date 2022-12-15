<?php

declare (strict_types=1);

namespace App\Http\Controllers;

use App\Book;
use App\BookReview;
use App\Http\Requests\PostBookRequest;
use App\Http\Requests\PostBookReviewRequest;
use App\Http\Resources\BookResource;
use App\Http\Resources\BookReviewResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class BooksController extends Controller
{
    private const PER_PAGE_PAGINATION = 15;

    public function __construct()
    {
        $this->middleware('auth', ['only' => ['post', 'postReview']]);
    }

    public function getCollection(Request $request): AnonymousResourceCollection
    {
        $books = Book::query()
            ->withAvg('reviews as avg_review', 'review')
            ->title($request->title)
            ->author($request->authors)
            ->orderBy($request->sortColumn, $request->sortDirection ?? 'ASC')
            ->paginate(self::PER_PAGE_PAGINATION);

        return BookResource::collection($books);
    }

    public function post(PostBookRequest $request): BookResource
    {
        $book = Book::query()->create([
            'isbn' => $request->isbn,
            'title' => $request->title,
            'description' => $request->description
        ]);
        $book->authors()->attach($request->authors);

        return new BookResource($book);
    }

    public function postReview(Book $book, PostBookReviewRequest $request): BookReviewResource
    {
        $review = new BookReview([
            'review' => $request->review,
            'comment' => $request->comment
        ]);

        $review->user()->associate(Auth::user());

        $book->reviews()->save($review);

        return new BookReviewResource($review);
    }
}
