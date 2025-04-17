<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Salle extends Model
{
    protected $fillable = ['nom', 'capacite', 'surface'];

    /**
     * Summary of reservations
     * @return HasMany<Reservation, Salle>
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Summary of estDisponible
     * @param mixed $debut
     * @param mixed $fin
     * @return bool
     */
    public function estDisponible($debut, $fin)
    {
        return !$this->reservations()
            ->where(function ($query) use ($debut, $fin) {
                $query->whereBetween('heure_debut', [$debut, $fin])
                    ->orWhereBetween('heure_fin', [$debut, $fin])
                    ->orWhere(function ($q) use ($debut, $fin) {
                        $q->where('heure_debut', '<=', $debut)
                            ->where('heure_fin', '>=', $fin);
                    });
            })->exists();
    }
}
