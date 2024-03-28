<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItineraireAVisiter extends Model
{
    use HasFactory;

    protected $table = 'itineraires_a_visiter';

    protected $fillable = [
        'user_id', 'itineraire_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function itineraire()
    {
        return $this->belongsTo(Itineraire::class);
    }

    public static function ajouterAVisiter($userId, $itineraireId)
    {
        return self::create([
            'user_id' => $userId,
            'itineraire_id' => $itineraireId,
        ]);
    }
}
