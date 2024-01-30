<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $fillable = ['date_debut','date_fin','prix_total','etat','voitureID','userID'];
    public function voitures()
{ 
    return $this->belongsTo(Voiture::class, "voitureID");
}
public function users()
{ 
    return $this->belongsTo(Voiture::class, "userID");
}
}
