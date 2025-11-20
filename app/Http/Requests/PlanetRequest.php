<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlanetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // tu gères l'accès avec tes middlewares
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'name_en' => ['nullable', 'string', 'max:100'],   // 👈 OBLIGATOIRE
            'slug' => ['nullable', 'string', 'max:120', Rule::unique('planets', 'slug')->ignore($this->planet)],
            'order' => ['nullable', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'distance' => ['nullable', 'string', 'max:100'],
            'travel_time' => ['nullable', 'string', 'max:100'],
            'published' => ['sometimes', 'boolean'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'published' => (bool) $this->boolean('published'),
        ]);
    }



    public function messages(): array
    {
        return [
            'name.required' => 'Le nom est obligatoire.',
            'slug.alpha_dash' => 'Le slug ne doit contenir que des lettres, chiffres, tirets et underscores.',
        ];
    }
}
