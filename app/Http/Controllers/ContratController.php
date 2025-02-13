<?php

namespace App\Http\Controllers;

use App\Models\Contrat;
use App\Models\Mdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class ContratController extends Controller
{
    public function index()
    {
        return Contrat::with(['client', 'mdf'])->get();
    }



    public function show($NumContrat)
    {
        return Contrat::findOrFail($NumContrat);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'NumContrat' => 'required',
            'Etat' => 'required',
            'date' => 'required|date',
            'clientId' => 'required|exists:clients,CodeClient',
            'mdfId' => 'required|exists:mdf,NumSerie',
            'superviseur' => 'nullable|string',
        ]);



        $contrat = Contrat::create($validated);

        return response()->json(['message' => 'Contrat créé avec succès', 'data' => $contrat], 201);
    }


    public function update(Request $request, $NumContrat)
    {
        $contrat = Contrat::findOrFail($NumContrat);
        $contrat->update($request->all());
        return response()->json(['message' => 'Contrat mis à jour', 'data' => $contrat]);
    }

    public function destroy($NumContrat)
    {
        $contrat = Contrat::findOrFail($NumContrat);
        $contrat->delete();
        return response()->json(['message' => 'Contrat supprimé avec succès']);
    }

    public function resilier($NumContrat)
    {
        $contrat = Contrat::findOrFail($NumContrat);
        $contrat->Etat = "Résilié";
        $contrat->save();

        return response()->json(['message' => 'Contrat résilié avec succès.', 'data' => $contrat]);
    }
    public function getResilies()
    {
        $contrats = Contrat::where('Etat', 'Résilié')->with(['client', 'mdf'])->get();
        return response()->json($contrats);
    }


    public function restaurer($NumContrat)
    {
        $contrat = Contrat::findOrFail($NumContrat);

        // Vérification si le contrat est résilié
        if ($contrat->Etat !== "Résilié") {
            return response()->json(['message' => 'Le contrat n\'est pas résilié.'], 400);
        }

        // Restauration du contrat
        $contrat->Etat = "Actif";
        $contrat->save();

        // Si le MDF est concerné, on peut aussi le mettre à "En prêt" si nécessaire
        if ($contrat->mdf) {
            $mdf = Mdf::find($contrat->mdfId);
            if ($mdf) {
                $mdf->Etat = 'En prêt';
                $mdf->save();
            }
        }

        return response()->json(['message' => 'Contrat restauré avec succès.', 'data' => $contrat]);
    }




    public function echangerMdf(Request $request)
    {
        $contrat = Contrat::where('NumContrat', $request->NumContrat)->first();
        if (!$contrat) {
            return response()->json(['message' => 'Contrat non trouvé'], 404);
        }

        $oldMdf = Mdf::where('NumSerie', $contrat->mdfId)->first();
        if (!$oldMdf) {
            return response()->json(['message' => 'Ancien MDF non trouvé'], 404);
        }

        $newMdf = Mdf::where('NumSerie', $request->mdfId)->where('Etat', 'Disponible En Stock')->first();
        if (!$newMdf) {
            return response()->json(['message' => 'Nouveau MDF non disponible'], 400);
        }

        try {
            DB::transaction(function () use ($contrat, $oldMdf, $newMdf) {
                $oldMdf->Etat = 'Disponible En Stock';
                $oldMdf->save();

                $newMdf->Etat = 'En prêt';
                $newMdf->save();

                $contrat->mdfId = $newMdf->NumSerie;
                $contrat->save();
            });

            return response()->json(['message' => 'Échange effectué avec succès'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de léchange du MDF', 'error' => $e->getMessage()], 500);
        }
    }

    public function transfertMdf(Request $request)
    {
        $request->validate([
            'ancienContratId' => 'required|exists:contrats,NumContrat',
            'nouveauClientId' => 'required|exists:clients,CodeClient',
        ]);

        $contrat = Contrat::with(['client', 'mdf'])->where('NumContrat', $request->ancienContratId)->first();

        if (!$contrat) {
            return response()->json(['message' => 'Contrat non trouvé.'], 404);
        }

        $mdf = $contrat->mdf;
        $ancienClientId = $contrat->clientId;

        if (!$mdf) {
            return response()->json(['message' => 'MDF non trouvé pour ce contrat.'], 404);
        }

        $contrat->Etat = "Résilié";
        $contrat->save();

        $nouveauContratExistant = Contrat::where('clientId', $request->nouveauClientId)->first();

        if (!$nouveauContratExistant) {
            return response()->json(['message' => 'Aucun contrat trouvé pour ce client.'], 404);
        }

        $mdfNouveauClient = Mdf::where('NumSerie', $nouveauContratExistant->mdfId)->first();

        if (!$mdfNouveauClient) {
            return response()->json(['message' => 'Aucun MDF disponible en stock pour le nouveau client.'], 404);
        }

        $nouveauContrat = new Contrat();
        $nouveauContrat->NumContrat;
        $nouveauContrat->clientId = $request->nouveauClientId;
        $nouveauContrat->mdfId = $mdf->NumSerie;
        $nouveauContrat->Etat = "Actif";
        $nouveauContrat->date = now();
        $nouveauContrat->superviseur = $nouveauContrat->superviseur ?? "Non Spécifié";
        $nouveauContrat->save();

        $mdfNouveauClient->Etat = 'Disponible En Stock';
        $mdfNouveauClient->save();

        return response()->json(['message' => 'Transfert effectué avec succès.']);
    }



}
