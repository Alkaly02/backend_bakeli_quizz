<?php

namespace App\Http\Controllers;

use App\Http\Resources\ExamenCollection;
use App\Http\Resources\ExamenRessource;
use App\Models\Domaine;
use App\Models\Examen;
use App\Models\SousDomaine;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ExamenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $examens = Domaine::with([
            'sous_domaines.examens'
        ])->get();

        return response()->json(new ExamenCollection($examens), Response::HTTP_OK);
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
            'sous_domaine_id' => 'required'
        ]);
        // echo $request->name;

        $sous_domaine = SousDomaine::findOrFail($request->sous_domaine_id);
        $examen = $sous_domaine->examens()->create([
            'name' => $request->name,
            'duree' => $request->duree

        ]);

        foreach ($request->questions as $question) {
            /**
             * Create new question related to that quizz.
             */
            $new_question = $examen->questions()->create([
                'question' => $question['question']
            ]);

            if (!$new_question) {
                $examen->delete();
                return response()->json(['error' => "Erreur lors de le creation de l'examen"], Response::HTTP_NOT_FOUND);
            }

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

        return response()->json(new ExamenRessource($examen), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Examen  $examen
     * @return \Illuminate\Http\Response
     */
    public function show(Examen $examen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Examen  $examen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Examen $examen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Examen  $examen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Examen $examen)
    {
        //
    }
}