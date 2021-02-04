<?php

use App\Http\Controllers\QuestionaireController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/infoLaraVel', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/',[QuestionaireController::class,'showForm']);
Route::get('/testq',[QuestionaireController::class,'makeQuestionaire']);
Route::post('/covidans',[QuestionaireController::class,'insertData']);
Route::get('/info/{id}',[QuestionaireController::class,'checkIn']);
Route::post('/checkin',[QuestionaireController::class,'doCheckIn']);
Route::get('/viewPeople',[QuestionaireController::class,'viewPerson']);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');
