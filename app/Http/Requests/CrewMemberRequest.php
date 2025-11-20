<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrewMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'         => ['required', 'string', 'max:100'],
            'slug'         => ['nullable', 'string', 'max:120'],

            // FR
            'role'         => ['required', 'string', 'max:100'],
            'bio'          => ['nullable', 'string'],

            // EN
            'role_en'      => ['nullable', 'string', 'max:100'],
            'bio_en'       => ['nullable', 'string'],

            'order'        => ['nullable', 'integer', 'min:0'],

            // IMPORTANT : même nom que la colonne ET que le champ du form
            'is_published' => ['sometimes', 'boolean'],

            'image'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    // ⭐ ICI : le merge dont on parlait
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_published' => (bool) $this->boolean('is_published'),
        ]);
    }
}
