<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuditLog;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        return AuditLog::orderBy('created_at', 'desc')->limit(100)->get();
    }
}
