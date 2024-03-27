<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destination;
use App\Models\Itineraire;

class DestinationController extends Controller
{
    public function addDestination(Request $request, $itineraireId)
    {
        $itineraire = Itineraire::findOrFail($itineraireId);

        $destination = new Destination([
            'nom' => $request->nom,
            'lieu_logement' => $request->lieu_logement,
            'itineraire_id' => $itineraire->id,
        ]);

        $destination->save();

        return response()->json(['message' => 'Destination ajoutée avec succès à l\'itinéraire'], 200);
    }


}

