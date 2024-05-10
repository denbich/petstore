<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;

Route::view('/', 'welcome')->name('main');
Route::redirect('/home', '/pet');

Route::middleware(['auth'])->group(function(){
    Route::resource('/pet', PetController::class)->except(['create',  'show']);
});
