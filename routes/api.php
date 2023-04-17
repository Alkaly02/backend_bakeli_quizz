<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CoursController;
use App\Http\Controllers\DomaineController;
use App\Http\Controllers\QuizzController;
use App\Http\Controllers\SousDomaineController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

# Auth
Route::prefix('auth')->group(function () {
    Route::get('/', [AuthController::class, 'getUser']);
    Route::post('login',  [AuthController::class, 'login']);
    Route::post('register',  [AuthController::class, 'register']);
    Route::get('refresh_token',  [AuthController::class, 'refreshToken']);
    Route::get('logout',  [AuthController::class, 'logout']);
    // Route::post('login', 'AuthController@login')->name('auth.login.post');
    // Route::post('logout', 'AuthController@logout')->name('auth.logout');
});


# domaine
Route::apiResource("/domaines", DomaineController::class);

# sous domaines
Route::get("/sous_domaines/domaines/{domaine}", [SousDomaineController::class, 'get_domaine_sous_domaines']);
Route::apiResource("/sous_domaines", SousDomaineController::class);

# cours
Route::get("/cours/sous_domaines/{sous_domaine}", [CoursController::class, 'get_cours_by_sous_domaine']);
Route::apiResource("/cours", CoursController::class);

# quizzes
Route::post("/quizzes/choix", [QuizzController::class, 'add_questions_choix']);
Route::get("/quizzes/questions/{quizz}", [QuizzController::class, 'get_quizz_questions']);
Route::get("/cours/quizzes/{cours}", [QuizzController::class, 'get_quizzes_by_cours']);
Route::apiResource("/quizzes", QuizzController::class);