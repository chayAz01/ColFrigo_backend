<?php

namespace App\Http\Controllers;

use App\Models\Mdf;
use Illuminate\Http\Request;

class MdfController extends Controller
{
    //lister tous les mdf
    public function index()
    {
        $mdfs = Mdf::with(['contratActif.client'])->get();

        return response()->json($mdfs);
    }

    //ajouter un Mdf
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'CodeColaimo' => 'required|string|unique:mdf,CodeColaimo',
            'NumSerie' => 'required|integer',
            'Type' => 'required|string|max:255',
            'Marque' => 'required|string|max:255',
            'Fabrication' => 'nullable|string',
            'Predentenseur' => 'nullable|string',
            'Etat' => 'required|string',
            'image' => 'nullable|image',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/mdf', 'public');
        } else {
            $imagePath = null;
        }
        $mdf = Mdf::create([
            ...$validatedData,
            'image' => $imagePath,
        ]);

        return response()->json([
            'message' => 'MDF ajouté avec succès.',
            'mdf' => $mdf
        ], 201);
    }

    //trouver un MDF
    public function show($NumSerie)
    {
        $mdf = Mdf::with(['contratActif.client'])->find($NumSerie);

        if (!$mdf) {
            return response()->json(['message' => 'MDF non trouvé.'], 404);
        }

        return response()->json($mdf);
    }

    //modifier un mdf
    public function update(Request $request, $NumSerie)
    {
        $mdf = Mdf::find($NumSerie) ;

        if (!$mdf) {
            return response()->json(['message' => 'MDF non trouvé.'], 404);
        }

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/mdf', 'public');
            $mdf->image = $imagePath;
        }

        $mdf->update($request->all());

        return response()->json([
            'message' => 'MDF mis à jour avec succès.',
            'mdf' => $mdf,
        ]);
    }

    //supprimer un MDF
    public function destroy($NumSerie)
    {
        $mdf = Mdf::find($NumSerie) ;

        if (!$mdf) {
            return response()->json(['message' => 'MDF non trouvé.'], 404);
        }

        $mdf->delete();

        return response()->json(['message' => 'MDF supprimé avec succès .']);
    }

    //restaurer un MDF
    public function restore($NumSerie){
        $mdf = Mdf::onlyTrashed()->find($NumSerie) ;

        if (!$mdf) {
            return response()->json(['message' => 'MDF non trouvé ou non supprimé.'], 404);
        }

        $mdf->restore() ;

        return response()->json([
            'message' => 'MDF restauré avec succès.',
            'mdf' => $mdf
        ]);
    }

    public function getDeletedMdfs(){
        $deletedMdfs = Mdf::onlyTrashed()->get();
        return response()->json($deletedMdfs);
    }

    public function updateEtat(Request $request, $NumSerie)
    {
        $mdf = Mdf::findOrFail($NumSerie);
        $mdf->Etat = $request->Etat;
        $mdf->save();

        return response()->json(['message' => 'État MDF mis à jour avec succès']);
    }
}
