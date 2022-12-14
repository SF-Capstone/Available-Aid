<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\SheetsController;

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

/*Route::get('/', function () {
    return view('welcome');
});

Route::controller(WelcomeController::class)->group(function(){
    Route::get('/', 'show')->name('welcome');
});
*/

Route::controller(WelcomeController::class)->group(function(){
    Route::get('/images/{imageName?}', 'getImage')->name('getImage');
});


Route::controller(SheetsController::class)->group(function(){
    Route::get('/', 'getFilterInfo')->name('getFilterInfo');
    Route::get('/results', 'getShelterInfo')->name('results');
    Route::get('/results/{shelterName}', 'getMoreInfo')->name('info');
    Route::get('/map/{shelterName}', 'getShelterLocation')->name('mapView');
});