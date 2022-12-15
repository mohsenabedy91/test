<?php

declare (strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'isbn' => $this->isbn,
            'title' => $this->title,
            'description' => $this->description,
            'authors' => AuthorResource::collection($this->authors),
            'review' => [
                'avg' => (int) round($this->reviews->avg('review') ?? 0),
                'count' => (int) $this->reviews->count()
            ]
        ];
    }

    public function toResponse($request)
    {
        return parent::toResponse($request)
            ->setStatusCode(Response::HTTP_CREATED);
    }
}
