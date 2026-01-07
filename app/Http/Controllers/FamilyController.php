<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Family;

class FamilyController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()->families;
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required']);
        $family = Family::create($data);
        $family->users()->attach($request->user()->id);
        return $family;
    }

    public function addUser(Request $request, $familyId)
    {
        $family = Family::findOrFail($familyId);
        $userId = $request->input('user_id');
        $family->users()->attach($userId);
        return $family->load('users');
    }
}
