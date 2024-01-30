<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locations = Location::with('voitures','users')->get();
            return $locations;
    }

    /**
     * Store a newly created resource in storage.
     */
    
    public function store(Request $request)
    {
        $location = new Location([
            'date_debut' => $request->input('date_debut'),
            'date_fin' => $request->input('date_fin'),
            'prix_total' => $request->input('prix_total'),
            'etat' => $request->input('etat'),
            'voitureID' => $request->input('voitureID'),
            'userID' => $request->input('userID')
        ]);
        $location->save();
        return response()->json("location ajouté avec succées");
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    
    {
        $location = Location::find($id);
        return response()->json($location);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $location = Location::find($id);
        $location->update($request->all());
        return response()->json($location, 200);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $location = Location::find($id);
        $location->delete();
        return response()->json('location supprimée !');
    }
    public function showLocationByUser($iduser)
    {
        $locations = Location::where('userID', $iduser)->with('users')->get();
        return response()->json($locations);
    }
}
