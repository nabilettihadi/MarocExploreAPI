<?php

// database/factories/ItineraireFactory.php

namespace Database\Factories;

use App\Models\Itineraire;
use App\Models\Categorie;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItineraireFactory extends Factory
{
    protected $model = Itineraire::class;

    public function definition()
    {
        // Obtenez un ID de catégorie existant ou en créez un nouveau
        $categorieId = Categorie::inRandomOrder()->firstOrCreate([
            'nom' => $this->faker->word,
        ])->id;

        return [
            'titre' => $this->faker->sentence,
            'categorie_id' => $categorieId, // Utilisez categorie_id au lieu de categorie
            'image' => $this->faker->imageUrl(),
            'duree' => $this->faker->randomNumber(2),
            'user_id' => function () {
                return \App\Models\User::factory()->create()->id;
            },
        ];
    }
}