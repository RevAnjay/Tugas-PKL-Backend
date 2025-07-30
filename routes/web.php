<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SmkController;

Route::get('/', function () {
    return view('welcome');
});

