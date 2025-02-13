<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mdf extends Model
{
    use HasFactory , SoftDeletes;

    protected $table = 'mdf';
    protected $primaryKey = 'NumSerie';



    protected $fillable = [
        'CodeColaimo' , 'NumSerie' , 'Type' , 'Marque', 'Fabrication' ,
        'Predetenseur' , 'Etat' , 'image'
    ] ;

    public function contrats(){
        return $this->hasMany(Contrat::class, 'mdfId' , 'NumSerie') ;
    }

    public function contratActif()
    {
        return $this->hasOne(Contrat::class, 'mdfId', 'NumSerie')->where('Etat', 'Actif');
    }
}
