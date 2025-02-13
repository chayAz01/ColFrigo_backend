<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrat extends Model
{
    use HasFactory ;

    protected $primaryKey = 'NumContrat' ;
    public $incrementing = false ;

    protected $fillable = [
        'NumContrat', 'Etat', 'date',
        'clientId', 'mdfId' , 'superviseur'
    ] ;

    public function client() {
        return $this->belongsTo(Client::class, 'clientId', 'CodeClient');
    }

    public function mdf() {
        return $this->belongsTo(Mdf::class, 'mdfId', 'NumSerie');
    }

}
