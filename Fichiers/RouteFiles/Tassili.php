<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;

Route::get('/tassili/router',[\Tassili\Prime\Http\Resources\TassiliRouter::class,'index'])->middleware('auth');
Route::get('/tassili/router/create',[\Tassili\Prime\Http\Resources\TassiliRouter::class,'create'])->middleware('auth');
Route::get('/tassili/router/update/{id}',[\Tassili\Prime\Http\Resources\TassiliRouter::class,'update'])->middleware('auth');
Route::post('/tassili/router/creator',[\Tassili\Prime\Http\Resources\TassiliRouter::class,'creator'])->middleware('auth');
Route::post('/tassili/router/updator',[\Tassili\Prime\Http\Resources\TassiliRouter::class,'updator'])->middleware('auth');
Route::post('/tassili/router/updateActive',[\Tassili\Prime\Http\Resources\TassiliRouter::class,'updateActive'])->middleware('auth');
Route::post('/tassili/router/delete',[\Tassili\Prime\Http\Resources\TassiliRouter::class,'delete'])->middleware('auth');
Route::post('/tassili/logout',[\Tassili\Prime\Http\Resources\TassiliRouter::class,'logout'])->middleware('auth');
Route::post('/tassili/deleteRecord',[\Tassili\Prime\Http\Resources\TassiliRouter::class,'deleteRecord'])->middleware('auth');

Route::post('tassili17485RRY4R4RD9448RK48K4RFRFIRU/valideur/framework', function (Request $request) {

    $requiredPermissions = json_decode($request->input('permissions17485RRY4R4RD9448RK48K4RFRFIRU'), true);

    if (!empty($requiredPermissions)) {
        $userPermissions = auth()->user()->getAllPermissions()->pluck('name')->toArray();

        $hasPermission = !empty(array_intersect($requiredPermissions, $userPermissions));

        if (!$hasPermission) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    }


   $urlValidation = $request->input('urlValidationurlValidationurlValidationTassili17485RRY4R4RD9448RK48K4RFRFIRU');

    $parts = explode('-fonction-', $urlValidation);

    $classe  = $parts[0];          
    $fonction = $parts[1];     

    return app($classe)->$fonction($request);
});