<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Silber\Bouncer\BouncerFacade as Bouncer;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Bouncer::role()->firstOrCreate([
            'name' => 'admin',
        ], ['title' => 'Administrateur']);

        Bouncer::role()->firstOrCreate([
            'name' => 'employe',
        ], ['title' => 'Employé']);
    }

}
