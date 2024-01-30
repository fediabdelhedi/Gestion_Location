<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voiture extends Model
{
    use HasFactory;
    protected $fillable = ['matricule','marque','model','couleur','date_fabrication','prix'];
    public function locations()
    { 
        return $this->hasMany(Location::class, "voitureID"); 
    }
}
