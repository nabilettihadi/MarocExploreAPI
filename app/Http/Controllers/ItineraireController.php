<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Itineraire;
use App\Models\Destination;
use Illuminate\Support\Facades\Auth;

class ItineraireController extends Controller
{
    public function create(Request $request)
    {
        $user = Auth::user();

        $itineraire = new Itineraire([
            'titre' => $request->titre,
            'categorie' => $request->categorie,
            'duree' => $request->duree,
            'image' => $request->image,
            'user_id' => $user->id,
        ]);

        $itineraire->save();

        return response()->json(['message' => 'Itineraire créé avec succès'], 201);
    }

    public function addDestination(Request $request, $itineraireId)
    {
        $itineraire = Itineraire::findOrFail($itineraireId);

        // Logique pour ajouter une destination à un itinéraire

        return response()->json(['message' => 'Destination ajoutée avec succès à l\'itinéraire'], 200);
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
