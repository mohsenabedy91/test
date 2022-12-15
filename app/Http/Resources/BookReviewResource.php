<?php

declare (strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

class BookReviewResource extends JsonResource
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
            "id" => $this->id,
            "review" => $this->review,
            "comment" => $this->comment,
            "user" => $this->user
        ];
    }

    public function toResponse($request)
    {
        return parent::toResponse($request)
            ->setStatusCode(Response::HTTP_CREATED);
    }
}
