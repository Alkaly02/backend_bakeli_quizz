<?php

namespace App\Http\Controllers;

use App\Http\Resources\TentativeCollection;
use App\Http\Resources\TentativeRessource;
use App\Models\Tentative;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class TentativeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $sous_domaines = SousDomaine::with(['domaine', 'cours'])->get();
        $tentatives = Tentative::get();
        return response()->json(new TentativeCollection($tentatives), Response::HTTP_OK);
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
            "quizz_id" => "required"
        ]);

        $sous_domaine = Tentative::create($request->only([
            'quizz_id'
        ]));

        return response()->json(new TentativeRessource($sous_domaine), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tentative  $tentativeId
     * @return \Illuminate\Http\Response
     */
    public function show($tentativeId)
    {
        $_tentative = Tentative::with([
            'quizz',
            'quizz.questions',
            'quizz.questions.reponses',
            'quizz.questions.choix' => function ($choix) use ($tentativeId) {
                $choix->where('tentative_id', $tentativeId);
            }
        ])->find($tentativeId);

        return response()->json($_tentative, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tentative  $tentative
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tentative $tentative)
    {
        $tentative->delete();

        return response()->json("", Response::HTTP_NO_CONTENT);
    }
}
