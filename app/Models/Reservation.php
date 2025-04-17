<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    /**
     * Summary of user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, Reservation>
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function salle() {
        return $this->belongsTo(Salle::class);
    }
}
