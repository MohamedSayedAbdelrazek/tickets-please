<?php

use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);


//Route::apiResource → شالت الـ create و edit routes (لأنهم خاصين بالـ HTML forms).
Route::controller(TicketController::class)->group(function(){
    Route::get('/tickets','index');
    Route::get('/tickets/{id}','show');
    Route::post('/tickets','store');
    Route::put('/tickets/{id}', 'update');   
    Route::delete('/tickets/{id}','destroy');
});