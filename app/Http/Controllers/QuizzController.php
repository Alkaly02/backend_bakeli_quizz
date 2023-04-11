<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionCollection;
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

        $cours = Cours::find($request->cours_id);
        $quizz = $cours->quizzes()->create([
            'name' => $request->name
        ]);

        foreach ($request->questions as $question) {
            /**
             * Create new question related to that quizz.
             */
            $new_question = $quizz->questions()->create([
                'question' => $question['question']
            ]);

            if (count($question['answerOptions'])) {
                foreach ($question['answerOptions'] as $answerOption) {
                    /**
                     * Create new reponse related to that question.
                     */
                    $new_question->reponses()->create([
                        'reponse' => $answerOption['reponse'],
                        'is_correct' => $answerOption['is_correct']
                    ]);
                }
            }
        }

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

        return response()->json(new QuizzCollection($quizzes), Response::HTTP_OK);
    }

    public function get_quizz_questions(Quizz $quizz)
    {
        $questions = $quizz->questions;
        foreach ($questions as $question) {
            $question['reponses'] = $question->reponses;
        }
        return response()->json(new QuestionCollection($questions), Response::HTTP_OK);
    }
}
