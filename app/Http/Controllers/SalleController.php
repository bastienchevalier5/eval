<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalleRequest;
use App\Models\Salle;
use Auth;
use Illuminate\Http\Request;

class SalleController extends Controller
{
    /**
     * Summary of index
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $salles = Salle::all();
        return view('salles.index', compact('salles'));
    }

    /**
     * Summary of create
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $salle = new Salle;
        return view('salles.form', compact('salle'));
    }

    /**
     * Summary of store
     * @param \App\Http\Requests\SalleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SalleRequest $request)
    {
        $salle = new Salle;
        $salle->nom = $request->nom;
        $salle->capacite = $request->capacite;
        $salle->surface = $request->surface;
        $salle->save();

        return redirect()->route('salles.index')->with('success', 'La salle a été ajouté avec succès.');
    }



    /**
     * Summary of edit
     * @param \App\Models\Salle $salle
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Salle $salle)
    {
        return view('salles.form', compact('salle'));
    }

    /**
     * Summary of update
     * @param \App\Http\Requests\SalleRequest $request
     * @param \App\Models\Salle $salle
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SalleRequest $request, Salle $salle)
    {
        $salle->nom = $request->nom;
        $salle->capacite = $request->capacite;
        $salle->surface = $request->surface;
        $salle->save();

        return redirect()->route('salles.index')->with('success', 'La salle a été modifié avec succès.');
    }

    /**
     * Summary of destroy
     * @param \App\Models\Salle $salle
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Salle $salle)
    {
        $salle->delete();
        return redirect()->route('salles.index')->with('success', 'La salle a été supprimée avec succès.');
    }
}
