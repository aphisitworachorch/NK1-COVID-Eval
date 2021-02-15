<?php

use App\Http\Controllers\QuestionaireController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
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

Route::post('/seedQuestionaire',[QuestionaireController::class,'makeAllQuestionaire']);
Route::post('/clearCache',function(){
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
});
