<?php

use App\Http\Controllers\TodoController;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/todos', [TodoController::class, 'index'])->can('viewAny', Todo::class);
    Route::post('/todos', [TodoController::class, 'store'])->can('create', Todo::class);
    Route::get('/todos/{todo}', [TodoController::class, 'show'])->can('view,todo');
    Route::put('/todos/{todo}', [TodoController::class, 'update'])->can('update,todo');
    Route::delete('/todos/{todo}', [TodoController::class, 'destroy'])->can('delete,todo');
});
