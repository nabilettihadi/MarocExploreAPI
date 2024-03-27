<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EndroitAVisiter extends Model
{
    use HasFactory;

    protected $table ='endroit_a_visiter';
    protected $fillable = [
        'nom_endroit', 'destination_id',
    ];

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }
}