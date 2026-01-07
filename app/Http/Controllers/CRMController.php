<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CRMController extends Controller
{
    public function subscribe(Request $request)
    {
        // Aquí iría la integración real con Mailchimp, Hubspot, etc.
        Log::info('CRM subscribe', $request->all());
        return response()->json(['ok' => true]);
    }
}
