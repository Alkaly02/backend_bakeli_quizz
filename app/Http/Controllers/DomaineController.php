<?php

namespace App\Http\Controllers;

use App\Http\Requests\DomaineRequest;
use App\Http\Resources\DomaineCollection;
use App\Http\Resources\DomaineResource;
use App\Models\Domaine;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Tymon\JWTAuth\Exceptions\JWTException;
// use Tymon\JWTAuth\Exceptions\TokenExpiredException;
// use Tymon\JWTAuth\Facades\JWTAuth;


class DomaineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $token = $request->header('Authorization');
        // try {
        //     $token = JWTAuth::parseToken($token);
        //     $payload = $token->getPayload();
        //     if ($payload['exp'] < time()) {
        //         throw new TokenExpiredException('Token has expired');
        //     }
        // } catch (TokenExpiredException $e) {
        //     // Token has expired
        //     return response()->json(['message' => 'Token has expired'], Response::HTTP_UNAUTHORIZED);
        // } catch (JWTException $e) {
        //     // Error while parsing token
        //     return response()->json(['message' => 'Error while parsing token'], Response::HTTP_UNAUTHORIZED);
        // }

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
            'name', "theme", "description", "image", "text_color",
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
        // echo($domaine);
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
            'name',
            "description",
            "theme", "text_color", "image"
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
