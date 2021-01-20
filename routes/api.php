<?php

use App\Http\Controllers\OptionController;
use App\Http\Controllers\QuestionController;
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


Route::get('questions', [QuestionController::class, 'index'])->name('questions');

Route::middleware('auth:sanctum')->post('/questions', [QuestionController::class, 'store'])->name('questions.store');
Route::get('/questions/show', [QuestionController::class, 'show'])->name('questions.show');

Route::delete('questions/{id}', [QuestionController::class, 'destroy']);

Route::get('options/{id}', [OptionController::class, 'index'])->name('options');
Route::post('options/{qid}/{oid}', [OptionController::class, 'store'])->name('options.store');
