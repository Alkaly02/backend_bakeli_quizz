<?php

namespace App\Http\Controllers;

use App\Http\Resources\SousDomaineCollection;
use App\Http\Resources\SousDomaineResource;
use App\Models\Domaine;
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
        $sous_domaines = SousDomaine::with(['domaine', 'cours'])->get();
        return response()->json(new SousDomaineCollection($sous_domaines), Response::HTTP_OK);
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
        return response()->json(new SousDomaineResource($sousDomaine->with('domaine')), Response::HTTP_OK);
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

        return response()->json(new SousDomaineResource($sousDomaine), Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SousDomaine  $sousDomaine
     * @return \Illuminate\Http\Response
     */
    public function destroy(SousDomaine $sousDomaine)
    {
        $sousDomaine->delete();

        return response()->json("", Response::HTTP_NO_CONTENT);
    }

    /**
     * Get all sous_domaines of a domaine
     *
     * @param  string $domaine_id
     * @return \Illuminate\Http\Response
     */
    public function get_domaine_sous_domaines(Domaine $domaine)
    {
        // $sous_domaine = $domaine->sous_domaines;
        $sous_domaines = $domaine->sous_domaines()->with('cours')->get();

        foreach ($sous_domaines as $sous_domaine) {
            $sous_domaine['cours'] = $sous_domaine->cours;
        }

        return response()->json(new SousDomaineCollection($sous_domaines), Response::HTTP_OK);
    }
}