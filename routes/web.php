<?php

use Illuminate\Support\Facades\Route;
use Luinuxscl\WordpressIntegration\Http\Controllers\WordpressController;

Route::prefix('wordpress')->group(function () {
    Route::post('/posts', [WordpressController::class, 'createPost'])->name('wordpress.createPost');
    Route::get('/posts/{id}', [WordpressController::class, 'getPost'])->name('wordpress.getPost');
});
