<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ABTestController extends Controller
{
    public function record(Request $request)
    {
        Log::info('A/B Test', $request->all());
        return response()->json(['ok' => true]);
    }
}
