<?php

namespace App\Http\Controllers;

use App\Http\Requests\DomaineRequest;
use App\Http\Resources\DomaineCollection;
use App\Http\Resources\DomaineResource;
use App\Models\Domaine;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DomaineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $domaines = Domaine::with('sous_domaines')->get();

        return response()->json(new DomaineCollection($domaines), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DomaineRequest $request)
    {
        $domaine = Domaine::create($request->only([
            'name'
        ]));

        return response()->json(new DomaineResource($domaine), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Domaine  $domaine
     * @return \Illuminate\Http\Response
     */
    public function show(Domaine $domaine)
    {
        return response()->json(new DomaineResource($domaine));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Domaine  $domaine
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Domaine $domaine)
    {
        // TODO: we can check if the user is authorized to update
        $domaine->update($request->only([
            'name'
        ]));

        return response()->json(new DomaineResource($domaine), Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Domaine  $domaine
     * @return \Illuminate\Http\Response
     */
    public function destroy(Domaine $domaine)
    {
        $domaine->delete();

        return response()->json("", Response::HTTP_NO_CONTENT);
    }
}