<?php

use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

//Route::apiResource → شالت الـ create و edit routes (لأنهم خاصين بالـ HTML forms).

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me',[AuthController::class,'me']);
    Route::post('/logout',[AuthController::class,'logout']);
    Route::post('/logoutAll',[AuthController::class,'logoutAll']);
    
    Route::controller(TicketController::class)->group(function () {
        Route::get('/tickets', 'index');
        Route::get('/tickets/{id}', 'show');
        Route::post('/tickets', 'store')->middleware('abilities:tickets.create');
;
        Route::put('/tickets/{id}', 'update')->middleware('abilities:tickets.update');
;
        Route::delete('/tickets/{id}', 'destroy')->middleware('abilities:tickets.delete');
    });
    
});
