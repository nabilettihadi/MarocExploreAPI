<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom', 'lieu_logement', 'itineraire_id',
    ];

    public function itineraire()
    {
        return $this->belongsTo(Itineraire::class);
    }

    public function endroitsAVisiter()
    {
        return $this->hasMany(EndroitAVisiter::class);
    }
}
