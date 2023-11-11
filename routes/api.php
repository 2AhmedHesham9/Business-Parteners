<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\PartenerController;
use App\Http\Controllers\DesignController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['middleware'=>['api']], function(){

    Route::group(['prefix' => 'admin'], function(){
        Route::post('register',[UserController::class,'register'])->middleware('auth.guard:admin-api');
        Route::post('login',[UserController::class,'login']);


        Route::post('createpartener',[PartenerController::class,'createpartener'])->middleware('auth.guard:admin-api');
        Route::post('updatepartener',[PartenerController::class,'updatepartener'])->middleware('auth.guard:admin-api');
        Route::delete('deletepartener/{id}',[PartenerController::class,'deletepartener'])->middleware('auth.guard:admin-api');
        Route::post('restorepartener/{id}',[PartenerController::class,'restorepartener'])->middleware('auth.guard:admin-api');

        // Route::post('createdesign',[DesignController::class,'createdesign'])->middleware('auth.guard:admin-api');
        Route::post('updatedesign',[DesignController::class,'updatedesign'])->middleware('auth.guard:admin-api');
        // Route::delete('deletedesign/{id}',[DesignController::class,'deletedesign'])->middleware('auth.guard:admin-api');


    });

});
Route::get('Showdesign',[DesignController::class,'Showdesign'])->middleware('auth.guard:admin-api'); //show parteners
Route::get('Showparteners',[PartenerController::class,'Showparteners'])->middleware('auth.guard:admin-api');
