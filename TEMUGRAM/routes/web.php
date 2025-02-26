<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});


Route::prefix('users')->group(base_path('routes/users/users.php'));
