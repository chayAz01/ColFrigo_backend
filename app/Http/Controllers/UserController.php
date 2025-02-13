<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comptes=Utilisateur::all() ;
        return response()->json($comptes) ;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = new Utilisateur();

        if ($request->hasFile('image')) {
            $imageName =  time().'.'.$request->image->extension();
            $request->image->storeAs('public/images', $imageName);
        }
        $user->cin = $request->cin;
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->tele = $request->tele;
        $user->role = $request->role;
        $user->image = $imageName ?? null;


        $user->save();

        return response()->json(['message' => 'Compte ajouté avec succès'], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $compte=Utilisateur::findOrFail($id) ;
        return response()->json($compte) ;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user=Utilisateur::findOrFail($id) ;
        $user->cin = $request->cin;
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->tele = $request->tele;
        $user->email = $request->email;
        $user->save() ;
        return 1 ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user=Utilisateur::findOrFail($id) ;
        $user->delete() ;
        return 1 ;
    }
}
