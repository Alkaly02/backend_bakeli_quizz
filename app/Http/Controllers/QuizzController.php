<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuizzCollection;
use App\Http\Resources\QuizzResource;
use App\Models\Cours;
use App\Models\Quizz;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class QuizzController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quizzes = Quizz::with('cours')->get();

        return response()->json(new QuizzCollection($quizzes), Response::HTTP_OK);
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
            'name' => 'required|max:100',
            'cours_id' => 'required'
        ]);

        $quizz = Quizz::create($request->only([
            'name', 'cours_id'
        ]));

        return response()->json(new QuizzResource($quizz), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quizz  $quizz
     * @return \Illuminate\Http\Response
     */
    public function show(Quizz $quizz)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quizz  $quizz
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quizz $quizz)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quizz  $quizz
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quizz $quizz)
    {
        //
    }

    public function get_quizzes_by_cours(Cours $cours)
    {
        $quizzes = $cours->quizzes;

        return response()->json(new QuizzCollection($quizzes, Response::HTTP_OK));
    }
}