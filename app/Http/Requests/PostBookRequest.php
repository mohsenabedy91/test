<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostBookRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'isbn' => 'required|unique:books|regex:/^(\d{13})?$/',
            'title' => 'required',
            'description' => 'required',
            'authors' => 'required|array',
            'authors.*' => 'required|exists:authors,id'
        ];
    }
}
