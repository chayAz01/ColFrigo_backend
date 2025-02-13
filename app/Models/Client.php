<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory , SoftDeletes ;
    protected $primaryKey= 'CodeClient' ;

    protected $fillable =  [
        'CodeClient' , 'nom' , 'prenom' , 'cin' , 'adresse' , 'telephone' ,
        'RaisonSociale' , 'RC' , 'Patente' , 'Secteur' , 'Region' , 'mdfId'
    ] ;

    public function contrats(){
        return $this->hasMany(Contrat::class, 'clientId' , 'CodeClient') ;
    }

    public function mdf()
    {
        return $this->belongsTo(Mdf::class, 'mdfId' , 'NumSerie');
    }

    public function contratActif()
    {
        return $this->hasOne(Contrat::class, 'clientId', 'CodeClient')->where('Etat', 'Actif');
    }

}
