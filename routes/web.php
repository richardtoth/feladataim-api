<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

Route::get('/health', static function () {
    try {
        DB::connection()->getPdo();
        $databaseStatus = 'ok';
    } catch (\Exception $e) {
        $databaseStatus = 'error';
    }

    return Response::json([
        'app_status' => 'ok',
        'database_status' => $databaseStatus
    ]);
})->middleware('throttle:10,1');