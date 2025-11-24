<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TechnologyRequest extends FormRequest
{
    public function authorize(): bool
    {
        // tu sécuriseras plus tard avec les rôles/permissions si besoin
        return true;
    }

    public function rules(): array
    {
        $technology = $this->route('technology'); // {technology} du route-model-binding
        $id = $technology?->id;

        return [
            'name' => [
                'required',
                'string',
                'max:150',
                Rule::unique('technologies', 'name')->ignore($id),
            ],
            'name_en' => [
                'nullable',
                'string',
                'max:150',
            ],
            'slug' => [
                'nullable',
                'string',
                'max:160',
                Rule::unique('technologies', 'slug')->ignore($id),
            ],

            'description'    => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],

            'website_url' => ['nullable', 'url', 'max:255'],
            'order'       => ['nullable', 'integer', 'min:0'],

            // Checkbox publiée
            'is_published' => ['nullable', 'boolean'],

            // Fichier image
            'image' => ['nullable', 'image', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'   => 'Le nom est obligatoire.',
            'name.unique'     => 'Ce nom est déjà utilisé.',
            'slug.unique'     => 'Ce slug est déjà utilisé.',
            'website_url.url' => 'Le site officiel doit être une URL valide.',
            'image.image'     => 'Le fichier doit être une image.',
            'image.max'       => 'L’image ne doit pas dépasser 2 Mo.',
        ];
    }
}
