<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        return Ticket::where('user_id', $request->user()->id)->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'subject' => 'required',
            'message' => 'required',
        ]);
        $data['user_id'] = $request->user()->id;
        return Ticket::create($data);
    }
}
