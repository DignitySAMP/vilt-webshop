<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ItemCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // TODO: policy to see if user has the right roles and is authenticated, for now always true
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $categoryId = $this->route('category')?->id; // null on create

        return [
            'name' => [
                'required',
                'min:4',
                'max:32',
                Rule::unique('item_categories', 'name')->ignore($categoryId),
            ],
            'description' => 'required|min:4|max:32',
        ];
    }
}
