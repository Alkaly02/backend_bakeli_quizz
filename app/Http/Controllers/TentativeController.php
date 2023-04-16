<?php

namespace App\Http\Controllers;

use App\Http\Resources\TentativeCollection;
use App\Http\Resources\TentativeRessource;
use App\Models\Tentative;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TentativeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tentatives = Tentative::with('quizz')->get();

        foreach ($tentatives as $tentative) {
            $tentative['reponses'] = json_decode($tentative->reponses);
        }

        return response()->json(new TentativeCollection($tentatives), Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'score' => 'required',
            'reponses' => 'required',
            "quizz_id" => 'required'
        ]);

        $tentative = new Tentative;
        $tentative->score = $request->score;
        $tentative->quizz_id = $request->quizz_id;
        $tentative->reponses = json_encode($request->reponses);

        $tentative->save();

        return response()->json(new TentativeRessource($tentative), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tentative  $tentative
     * @return \Illuminate\Http\Response
     */
    public function show(Tentative $tentative)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tentative  $tentative
     * @return \Illuminate\Http\Response
     */
    public function edit(Tentative $tentative)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tentative  $tentative
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tentative $tentative)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tentative  $tentative
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tentative $tentative)
    {
        //
    }
}
