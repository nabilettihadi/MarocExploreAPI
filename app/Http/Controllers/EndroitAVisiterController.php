<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EndroitAVisiter;
use App\Models\Destination;

class EndroitAVisiterController extends Controller
{
    // Méthode pour ajouter un endroit à visiter à une destination
    public function addEndroitAVisiter(Request $request, $destinationId)
    {
        $destination = Destination::findOrFail($destinationId);

        $endroitAVisiter = new EndroitAVisiter([
            'nom_endroit' => $request->nom_endroit,
            'destination_id' => $destination->id,
        ]);

        $endroitAVisiter->save();

        return response()->json(['message' => 'Endroit à visiter ajouté avec succès à la destination'], 200);
    }

    // Méthode pour récupérer tous les endroits à visiter d'une destination spécifique
    public function getEndroitsAVisiter($destinationId)
    {
        $destination = Destination::findOrFail($destinationId);

        $endroitsAVisiter = $destination->endroitsAVisiter()->get();

        return response()->json($endroitsAVisiter, 200);
    }

    // Méthode pour mettre à jour un endroit à visiter
    public function updateEndroitAVisiter(Request $request, $endroitAVisiterId)
    {
        $endroitAVisiter = EndroitAVisiter::findOrFail($endroitAVisiterId);

        $endroitAVisiter->update([
            'nom_endroit' => $request->nom_endroit,
        ]);

        return response()->json(['message' => 'Endroit à visiter mis à jour avec succès'], 200);
    }

    // Méthode pour supprimer un endroit à visiter
    public function deleteEndroitAVisiter($endroitAVisiterId)
    {
        $endroitAVisiter = EndroitAVisiter::findOrFail($endroitAVisiterId);

        $endroitAVisiter->delete();

        return response()->json(['message' => 'Endroit à visiter supprimé avec succès'], 200);
    }

    // Autres méthodes du contrôleur
}
