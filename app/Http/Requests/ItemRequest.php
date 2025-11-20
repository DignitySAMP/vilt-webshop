<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
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

        return [
            'name' => 'required|max:64',
            'category' => 'required|exists:item_categories,id',
            'supplier' => 'required|exists:suppliers,id',
            'description' => 'required|min:8',
            'image' => $this->isMethod('post') ? 'required|image|max:1500' : 'nullable|image|max:1500', // only require image if post(store)
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ];
    }
}
