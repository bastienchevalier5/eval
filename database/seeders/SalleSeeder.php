<?php

namespace Database\Seeders;

use App\Models\Salle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SalleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $salle = new Salle;
        $salle->nom = 'Salle de Réunion';
        $salle->capacite = 50;
        $salle->surface = 500;
        $salle->save();
    }
}
