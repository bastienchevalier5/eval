<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Summary of rules
     * @return string[]
     */
    public function rules(): array
    {
        $rules['nom'] = 'required|string|max:255|unique:salles,nom';
        $rules['capacite'] = 'required|integer|min:1';
        $rules['surface'] = 'required|integer|min:1';
        return $rules;
    }

    /**
     * Summary of messages
     * @return array{capacite.integer: string, capacite.min: string, capacite.required: string, nom.max: string, nom.required: string, nom.string: string, nom.unique: string, surface.integer: string, surface.min: string, surface.required: string}
     */
    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom est obligatoire.',
            'nom.string' => 'Le nom doit être dans un format valide.',
            'nom.unique' => 'Ce nom est déjà utilisé.',
            'nom.max' => 'Le nom ne doit pas dépasser 255 caractères.',
            'capacite.required' => 'La capacité est obligatoire.',
            'capacite.integer' => 'La capacité doit être dans un format valide.',
            'capacite.min' => 'La capacité ne doit pas être négative ou égale à 0.',
            'surface.required' => 'La surface est obligatoire.',
            'surface.integer' => 'La surface doit être dans un format valide.',
            'surface.min' => 'La surface ne doit pas être négative ou égale à 0.'
        ];
    }
}
