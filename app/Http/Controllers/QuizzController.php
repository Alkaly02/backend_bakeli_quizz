<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionCollection;
use App\Http\Resources\QuizzCollection;
use App\Http\Resources\QuizzResource;
use App\Models\Choix;
use App\Models\Cours;
use App\Models\Question;
use App\Models\Quizz;
use App\Models\Reponse;
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
        $quizzes = Quizz::with('tentatives')->get();

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
        $quizzes = $cours->quizzes()
            ->with(["tentatives"])
            ->get();
        // ->with('cours.sous_domaine')

        return response()->json(new QuizzCollection($quizzes), Response::HTTP_OK);
    }


    /**
     * Retrieve all questions related to a quizz and responses related to a question
     *
     * @param  \App\Models\Quizz  $quizz
     * @return \Illuminate\Http\Response
     */
    public function get_quizz_questions(Quizz $quizz)
    {
        $questions = $quizz->questions()->with(["reponses"])->get()->each(function ($questions) {
            $count = 0;
            foreach ($questions['reponses'] as $reponse) {
                if ($reponse['is_correct']) {
                    $count++;
                }
                $reponse->makeHidden(['is_correct']);
            }

            //Verify if count is more than 1
            if ($count > 1) {
                // We add a new element to the question
                $questions['manyOptions'] = true;
            } else {
                $questions['manyOptions'] = false;
            }
        });

        return response()->json(new QuestionCollection($questions), Response::HTTP_OK);
    }


    /**
     * store choices related to a quizz questions
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add_questions_choix(Request $request)
    {
        // {
        //     "quizz_id": 20,
        //     "tentative_id": 1
        //     "choix": [
        //         {
        //             "question_id": 4,
        //             "choixOptions": [7,9]
        //         },
        //         {
        //             "question_id": 5,
        //             "choixOptions": [10]
        //         }
        //     ]
        // }

        if (Quizz::findOrFail($request->quizz_id)) {
            foreach ($request->choix as $choix) {
                /**
                 * Check if the question exist
                 */
                $question = Question::findOrFail($choix['question_id']);
                if ($question) {
                    foreach ($choix['choixOptions'] as $id_reponse_choix) {
                        if (Reponse::findOrFail($id_reponse_choix)) {
                            $question->choix()->create([
                                'reponse_id' => $id_reponse_choix,
                                'tentative_id' => $request->tentative_id
                            ]);
                        }
                    }
                }
            }
        }
    }

    public function get_quizz_choix(Quizz $quizz)
    {
        $choix = $quizz->questions()
            ->with('reponses')
            ->with('choix')
            // ->select('id')
            ->get();
        // ->with('choix')
        // ->get();
        // echo $quizz->questions()
        //     ->with('reponses')
        //     ->with('choix')
        //     ->get();
        // $choix->makeHidden(['question_id']);
        return response()->json(new QuizzCollection($choix), Response::HTTP_OK);
    }
}
