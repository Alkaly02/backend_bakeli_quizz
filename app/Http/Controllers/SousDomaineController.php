<?php

namespace App\Http\Controllers;

use App\Http\Resources\SousDomaineResource;
use App\Models\SousDomaine;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SousDomaineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sous_domaines = SousDomaine::all();
        return response()->json(new SousDomaineResource($sous_domaines), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => "required|unique:sous_domaines|max:120",
            "domaine_id" => "required"
        ]);

        $sous_domaine = SousDomaine::create($request->only([
            'name', 'domaine_id'
        ]));

        return response()->json(new SousDomaineResource($sous_domaine), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SousDomaine  $sousDomaine
     * @return \Illuminate\Http\Response
     */
    public function show(SousDomaine $sousDomaine)
    {
        return response()->json(new SousDomaineResource($sousDomaine), Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SousDomaine  $sousDomaine
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SousDomaine $sousDomaine)
    {
        $sousDomaine->update($request->only([
            'name'
        ]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SousDomaine  $sousDomaine
     * @return \Illuminate\Http\Response
     */
    public function destroy(SousDomaine $sousDomaine)
    {
        //
    }
}