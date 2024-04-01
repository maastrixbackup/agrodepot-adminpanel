<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class OptimizeController extends Controller
{
    //
    public function optimize()
    {
        // Run the optimize command or any other optimization logic here
        Artisan::call('optimize');

        return response()->json('Application optimized successfully!');
    }
}
