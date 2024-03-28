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
            ->postJson('/api/itineraires/create', [
                'titre' => 'Test Itineraire',
                'categorie' => 'Test Catégorie',
                'image' => 'http://example.com/test.jpg',
                'duree' => '1 semaine',
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
        $this->assertEquals('Test Catégorie', $itineraire->categorie);
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
            'categorie' => 'Nouvelle Catégorie',
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
        $this->assertEquals('Nouvelle Catégorie', $itineraire->categorie);
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

    public function testSearchItineraires()
    {
        $itineraires = Itineraire::factory()->count(5)->create();

        $response = $this->getJson('/api/itineraires/search?titre=Test');

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Résultats de la recherche par titre',
                'itineraires' => $itineraires->toArray(),
            ]);
    }

    public function testFilterItineraires()
    {
        Itineraire::factory()->create(['categorie' => 'Plage', 'duree' => '1 semaine']);
        Itineraire::factory()->create(['categorie' => 'Montagne', 'duree' => '2 semaines']);

        $response = $this->getJson('/api/itineraires/filtrer?categorie=Plage');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'resultats')
            ->assertJson([
                'status' => 'success',
                'message' => 'Itinéraires filtrés avec succès',
            ]);
    }

    public function testAddToVisitList()
    {
        $itineraire = Itineraire::factory()->create();

        $response = $this->postJson("/api/itineraires/{$itineraire->id}/addToVisitList");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Itinéraire ajouté à la liste à visiter avec succès.',
            ]);
    }
}


