<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Source\Category\Interface\Controllers\CategoryController;
use Source\Photo\Interface\Controllers\PhotoController;
use Source\Resource\Interface\Controllers\ResourceController;

Route::get('/', function () {
    return \Inertia\Inertia::render('Home');
});

Route::get('/token', function (Request $request) {
    $token = $request->session()->token();

    $token = csrf_token();
});

// Move to admin layer in future
Route::get('photo/{id}', [PhotoController::class, 'get']);
Route::post('photo', [PhotoController::class, 'store']);

Route::get('category/{id}', [CategoryController::class, 'get']);
Route::post('category', [CategoryController::class, 'store']);

Route::get("{slug}", [ResourceController::class, 'getBySlug'])
    ->where([
        'slug' => '[a-z0-9\-\_\/]+'
    ]);
