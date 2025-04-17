<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Silber\Bouncer\BouncerFacade as Bouncer;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employe = new User;
        $employe->nom = 'Employé';
        $employe->prenom = 'Lambda';
        $employe->email = "employe@lambda.fr";
        $employe->password = Hash::make('employelambda');
        $employe->save();
        Bouncer::assign('employe')->to($employe);

        $admin = new User;
        $admin->nom = 'Administrateur';
        $admin->prenom = 'Administrateur';
        $admin->email = "admin@admin.fr";
        $admin->password = Hash::make('administrateur');
        $admin->save();
        Bouncer::assign('admin')->to($admin);
    }
}
