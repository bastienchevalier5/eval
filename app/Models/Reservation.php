<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    protected $fillable = ['salle_id', 'user_id', 'date', 'heure_debut', 'heure_fin', 'titre', 'description'];

    protected $casts = [
        'date' => 'date',
        'heure_debut' => 'datetime',
        'heure_fin' => 'datetime',
    ];

    /**
     * Summary of salle
     * @return BelongsTo<Salle, Reservation>
     */
    public function salle(): BelongsTo
    {
        return $this->belongsTo(Salle::class);
    }

    /**
     * Summary of user
     * @return BelongsTo<User, Reservation>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
