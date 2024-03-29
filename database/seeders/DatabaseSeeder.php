<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Itineraire;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */


    public function run()
    {
        // Création de données d'itinéraires pour les tests
        Itineraire::factory()->count(10)->create();
    }
}
