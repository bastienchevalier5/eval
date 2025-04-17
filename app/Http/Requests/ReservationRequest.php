<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
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
        $rules['salle_id'] = 'required|exists:salles,id';
        $rules['date'] = 'required|date';
        $rules['heure_debut'] = 'required|before:heure_fin';
        $rules['heure_fin'] = 'required|after:heure_debut';
        $rules['titre'] = 'required|string|max:255';
        $rules['description'] ='nullable|string';
        return $rules;
    }

    /**
     * Summary of messages
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'salle_id.required' => 'La salle est obligatoire.',
            'salle_id.exists' => 'La salle doit être existante.',
            'date.required' => 'La date est obligatoire.',
            'date.date' => 'La date doit être au bon format.',
            'heure_debut.required' => 'L\'heure de début est obligatoire.',
            'heure_debut.before' => 'L\'heure de début doit être avant l\'heure de fin.',
            'heure_fin.required' => 'L\'heure de fin est obligatoire',
            'heure_fin.after' => 'L\'heure de fin doit être après l\'heure de début.',
            'titre.required' => 'Le titre est obligatoire.',
            'titre.string' => 'Le titre doit être au bon format',
            'titre.max' => 'Le titre ne doit pas dépasser 255 caractères.'
        ];
    }
}
