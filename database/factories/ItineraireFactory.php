<?php

// database/factories/ItineraireFactory.php

namespace Database\Factories;

use App\Models\Itineraire;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItineraireFactory extends Factory
{
    protected $model = Itineraire::class;

    public function definition()
    {
        return [
            'titre' => $this->faker->sentence,
            'categorie' => $this->faker->word,
            'image' => $this->faker->imageUrl(),
            'duree' => $this->faker->randomNumber(2),
            'user_id' => function () {
                return \App\Models\User::factory()->create()->id;
            },
        ];
    }
}
