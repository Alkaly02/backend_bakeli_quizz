<?php

namespace App\Http\Controllers;

use App\Http\Resources\CoursCollection;
use App\Http\Resources\CoursResource;
use App\Models\Cours;
use App\Models\SousDomaine;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CoursController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cours = Cours::with('sous_domaine')->get();

        return response()->json(new CoursCollection($cours), Response::HTTP_OK);
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
            'name' => 'required|max:200',
            'content' => 'required',
            "sous_domaine_id" => 'required'
        ]);

        $cours = Cours::create($request->only([
            'name', 'content', 'sous_domaine_id', "description", "image"
        ]));

        return response()->json(new CoursResource($cours), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cours  $cours
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cours = Cours::with("sous_domaine.domaine")->find($id);
        if (!$cours) {
            return response()->json(['error' => 'Cours not found'], 404);
        }
        return response()->json(new CoursResource($cours), Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cours  $cours
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cours = Cours::findOrFail($id);

        $cours->update($request->only([
            'name', "content"
        ]));

        return response()->json(new CoursResource($cours), Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cours  $cours
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cours $cours)
    {
        $cours->delete();
        return response()->json("", Response::HTTP_NO_CONTENT);
    }

    public function get_cours_by_sous_domaine(SousDomaine $sous_domaine)
    {
        $cours = $sous_domaine->cours;
        return response()->json(new CoursCollection($cours), Response::HTTP_OK);
    }
}
