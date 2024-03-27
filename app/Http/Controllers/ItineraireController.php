<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Itineraire;
use App\Models\Destination;
use App\Models\EndroitAVisiter;
use Illuminate\Support\Facades\Auth;

class ItineraireController extends Controller
{
    public function create(Request $request)
    {
        try {
            $request->validate([
                'titre' => 'required|string|max:255',
                'categorie' => 'required|string|max:255',
                'image' => 'required|string',
                'duree' => 'required|string',
                'destinations' => 'required|array|min:2',
                'destinations.*.nom' => 'required|string|max:255',
                'destinations.*.lieu_logement' => 'required|string|max:255',
                'destinations.*.endroits_a_visiter' => 'required|array|min:1',
                'destinations.*.endroits_a_visiter.*.nom_endroit' => 'required|string|max:255',
            ]);

            $user = Auth::user();

            $itineraire = new Itineraire([
                'titre' => $request->titre,
                'categorie' => $request->categorie,
                'image' => $request->image,
                'duree' => $request->duree,
                'user_id' => $user->id,
            ]);

            $itineraire->save();

            $destinations = [];
            foreach ($request->destinations as $destinationData) {
                $destination = new Destination([
                    'nom' => $destinationData['nom'],
                    'lieu_logement' => $destinationData['lieu_logement'],
                    'itineraire_id' => $itineraire->id,
                ]);
                $destination->save();

                $endroits_a_visiter = [];
                foreach ($destinationData['endroits_a_visiter'] as $endroitData) {
                    $endroit = new EndroitAVisiter([
                        'nom_endroit' => $endroitData['nom_endroit'],
                        'destination_id' => $destination->id,
                    ]);
                    $endroit->save();
                    $endroits_a_visiter[] = $endroit;
                }

                $destination['endroits_a_visiter'] = $endroits_a_visiter;
                $destinations[] = $destination;
            }

            $itineraire['destinations'] = $destinations;

            return response()->json([
                'status' => 'success',
                'message' => 'Itinéraire avec ses destinations créé avec succès',
                'itineraire' => $itineraire,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }



    public function addDestinations(Request $request, $itineraireId)
    {
        try {
            $itineraire = Itineraire::findOrFail($itineraireId);

            $request->validate([
                'destinations' => 'required|array|min:1',
                'destinations.*.nom' => 'required|string|max:255',
                'destinations.*.lieu_logement' => 'required|string|max:255',
            ]);

            $destinations = [];
            foreach ($request->destinations as $destinationData) {
                $destination = new Destination([
                    'nom' => $destinationData['nom'],
                    'lieu_logement' => $destinationData['lieu_logement'],
                    'itineraire_id' => $itineraire->id,
                ]);
                $destination->save();
                $destinations[] = $destination;
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Destinations ajoutées à l\'itinéraire avec succès',
                'destinations' => $destinations,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function addToVisitList(Request $request, $itineraireId)
    {
        $user = Auth::user();

        // Logique pour ajouter un itinéraire à la liste à visiter de l'utilisateur

        return response()->json(['message' => 'Itinéraire ajouté à la liste à visiter'], 200);
    }

    public function index(Request $request)
    {
        $itineraires = Itineraire::all();

        return response()->json($itineraires, 200);
    }

    public function search(Request $request)
    {
        $query = Itineraire::query();

        if ($request->has('categorie')) {
            $query->where('categorie', $request->categorie);
        }

        if ($request->has('duree')) {
            $query->where('duree', $request->duree);
        }

        $itineraires = $query->get();

        return response()->json($itineraires, 200);
    }
}
