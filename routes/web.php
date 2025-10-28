<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Test route to preview 404 page (remove in production)
Route::get('/test-404', function () {
    abort(404);
});
