<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlanetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // l’accès est géré par tes middlewares/permissions
    }

    public function rules(): array
    {
        // En édition, on a un modèle {planet} dans la route
        $planetId = $this->route('planet')?->id;

        return [
            'name'        => ['required', 'string', 'max:255'],
            'slug'        => [
                'nullable', 'string', 'max:255', 'alpha_dash',
                Rule::unique('planets', 'slug')->ignore($planetId)
            ],
            'order'       => ['nullable', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'distance'    => ['nullable', 'string', 'max:255'],
            'travel_time' => ['nullable', 'string', 'max:255'],
            'image'       => ['nullable', 'string', 'max:255'], // chemin d'image (texte)
            'published'   => ['sometimes', 'boolean'],
        ];
    }

    public function prepareForValidation(): void
    {
        // Sécurise la case à cocher publiée
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
