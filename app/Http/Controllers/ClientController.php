<?php

namespace App\Http\Controllers;

use App\Models\Client;
use http\Env\Response;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    //lister tous les clients :
    public function index(){
        $clients = Client::all() ;
        return response()->json($clients) ;
    }

    //ajouter un client
    public function store(Request $request){
        $validatedData = $request->validate([
            'CodeClient' => 'required|unique:clients,CodeClient' ,
            'nom' => 'required|string|max:255' ,
            'prenom' => 'required|string|max:255' ,
            'cin' => 'required|string|max:20|unique:clients,cin' ,
            'adresse' => 'required|string|max:255' ,
            'telephone' => 'required|string|max:15' ,
            'RaisonSociale' => 'nullable|string|max:255' ,
            'RC' => 'nullable|string|max:50' ,
            'Patente' => 'nullable|string|max:255' ,
            'Secteur' => 'required|string|max:255' ,
            'Region' => 'required|string|max:255' ,
        ]) ;

        $client = Client::create($validatedData) ;

        return response()->json([
            'message' => 'Client ajouté avec succès.' ,
            'client' => $client ,
        ],201) ;
    }

    //trouver un client
    public function show($CodeClient)
    {
        $client = Client::with(['contratActif.mdf'])->where('CodeClient', $CodeClient)->firstOrFail();

        return response()->json($client);
    }


    //modifier un client
    public function update(Request $request, $CodeClient)
    {
        $client = Client::find($CodeClient);

        if (!$client) {
            return response()->json(['message' => 'Client non trouvé.'], 404);
        }

        $client->update($request->all());

        return response()->json([
            'message' => 'Client mis à jour avec succès.',
            'client' => $client
        ]);
    }


    //supprimer un client
    public function destroy($CodeClient)
    {
        // Trouver le client par son CodeClient
        $client = Client::find($CodeClient) ;

        // Vérifier si le client existe
        if (!$client) {
            return response()->json(['message' => 'Client non trouvé.'], 404); // Si non trouvé, retournez une erreur
        }

        // Supprimer le client
        $client->delete();

        return response()->json(['message' => 'Client supprimé avec succès.']);
    }


    //restaurer un client
    public function restore($CodeClient)
    {
        // Trouver le client supprimé avec 'onlyTrashed()'
        $client = Client::onlyTrashed()->find($CodeClient);

        if (!$client) {
            return response()->json(['message' => 'Client non trouvé ou non supprimé.'], 404);
        }

        // Restaurer le client
        $client->restore();

        return response()->json([
            'message' => 'Client restauré avec succès',
            'client' => $client
        ]);
    }

    public function getDeletedClients()
    {
        $deletedClients = Client::onlyTrashed()->get();
        return response()->json($deletedClients);
    }
}
