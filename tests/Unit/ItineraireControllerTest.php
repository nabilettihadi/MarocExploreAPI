<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Itineraire;
use App\Models\Destination;
use App\Models\EndroitAVisiter;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItineraireControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateItineraire()
    {
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/api/itineraires', [
                'titre' => 'Test Itineraire',
                'duree' => '1 semaine',
                'image' => 'http://example.com/test.jpg',
                'categorie_id' => 1, // Ajout de l'id de la catégorie existante
                'destinations' => [
                    [
                        'nom' => 'Destination 1',
                        'lieu_logement' => 'Hôtel A',
                        'endroits_a_visiter' => [
                            ['nom_endroit' => 'Endroit 1'],
                            ['nom_endroit' => 'Endroit 2'],
                        ],
                    ],
                    [
                        'nom' => 'Destination 2',
                        'lieu_logement' => 'Hôtel B',
                        'endroits_a_visiter' => [
                            ['nom_endroit' => 'Endroit 3'],
                        ],
                    ],
                ],
            ]);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'message' => 'Itinéraire avec ses destinations créé avec succès',
            ]);

        // Vérifier que l'itinéraire a été créé en base de données
        $itineraire = Itineraire::where('titre', 'Test Itineraire')->first();
        $this->assertNotNull($itineraire);
        $this->assertEquals(1, $itineraire->categorie_id); // Assertion sur l'id de la catégorie
        $this->assertEquals('http://example.com/test.jpg', $itineraire->image);
        $this->assertEquals('1 semaine', $itineraire->duree);

        // Vérifier que les destinations ont été créées et associées à l'itinéraire
        $this->assertCount(2, $itineraire->destinations);

        // Vérifier les endroits à visiter pour chaque destination
        $destination1 = Destination::where('nom', 'Destination 1')->first();
        $this->assertNotNull($destination1);
        $this->assertCount(2, $destination1->endroits_a_visiter);

        $destination2 = Destination::where('nom', 'Destination 2')->first();
        $this->assertNotNull($destination2);
        $this->assertCount(1, $destination2->endroits_a_visiter);
    }



    public function testAddDestinationsToItineraire()
    {
        $itineraire = Itineraire::factory()->create();

        $response = $this->postJson("/api/itineraires/{$itineraire->id}/addDestinations", [
            'destinations' => [
                ['nom' => 'Destination 1', 'lieu_logement' => 'Hôtel A'],
                ['nom' => 'Destination 2', 'lieu_logement' => 'Hôtel B'],
            ],
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'message' => 'Destinations ajoutées à l\'itinéraire avec succès',
            ]);

        // Vérifier que les destinations ont été ajoutées à l'itinéraire en base de données
        $itineraire = $itineraire->fresh();
        $this->assertCount(2, $itineraire->destinations);
    }


    public function testUpdateItineraire()
    {
        $itineraire = Itineraire::factory()->create();

        $response = $this->putJson("/api/itineraires/{$itineraire->id}/update", [
            'titre' => 'Itineraire Modifié',
            'image' => 'http://example.com/modified.jpg',
            'duree' => '2 semaines',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Itinéraire mis à jour avec succès',
            ]);

        // Vérifier que l'itinéraire a été mis à jour en base de données
        $itineraire = $itineraire->fresh();
        $this->assertEquals('Itineraire Modifié', $itineraire->titre);
        $this->assertEquals('http://example.com/modified.jpg', $itineraire->image);
        $this->assertEquals('2 semaines', $itineraire->duree);
    }

    public function testIndexItineraires()
    {
        $itineraires = Itineraire::factory()->count(5)->create();

        $response = $this->getJson('/api/itineraires');

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Liste des itinéraires récupérée avec succès',
                'itineraires' => $itineraires->toArray(),
            ]);
    }

    public function test_search_itineraires()
    {
        // Créer des itinéraires avec les colonnes nécessaires
        $itineraire1 = Itineraire::factory()->create([
            'titre' => 'Itineraire 1',
            'categorie' => 'Categorie 1',
            'duree' => '5 jours',
            'image' => 'https://example.com/image1.jpg',
            'user_id' => 1,
        ]);

        $itineraire2 = Itineraire::factory()->create([
            'titre' => 'Itineraire 2',
            'categorie' => 'Categorie 2',
            'duree' => '3 jours',
            'image' => 'https://example.com/image2.jpg',
            'user_id' => 2,
        ]);

        // Effectuer la recherche avec le titre 'Itineraire 1'
        $response = $this->getJson('/api/itineraires/search?titre=Itineraire 1');

        // Vérifier que la recherche a réussi avec le code de statut 200 et les données correctes
        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Résultats de la recherche par titre',
                'itineraires' => [$itineraire1->toArray()],
            ]);
    }

    public function testFilterItineraires()
    {
        Itineraire::factory()->create(['duree' => '1 semaine']);
        Itineraire::factory()->create(['duree' => '2 semaines']);

        $response = $this->getJson('/api/itineraires/filtrer?duree=1 semaine');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'resultats')
            ->assertJson([
                'status' => 'success',
                'message' => 'Itinéraires filtrés avec succès',
            ]);
    }

    public function testAddToVisitList()
    {
        $itineraire = Itineraire::factory()->create(['categorie_id' => 1]);

        $response = $this->postJson("/api/itineraires/{$itineraire->id}/addToVisitList");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Itinéraire ajouté à la liste à visiter avec succès.',
            ]);
    }
}
