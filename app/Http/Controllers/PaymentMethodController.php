<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()->paymentMethods;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'provider' => 'required',
            'provider_id' => 'required',
            'last4' => 'nullable',
            'brand' => 'nullable',
            'is_default' => 'boolean',
        ]);
        $data['user_id'] = $request->user()->id;
        if ($data['is_default'] ?? false) {
            PaymentMethod::where('user_id', $data['user_id'])->update(['is_default' => false]);
        }
        $pm = PaymentMethod::create($data);
        return $pm;
    }

    public function update(Request $request, $id)
    {
        $pm = PaymentMethod::where('user_id', $request->user()->id)->findOrFail($id);
        $pm->update($request->only(['is_default']));
        return $pm;
    }

    public function destroy(Request $request, $id)
    {
        $pm = PaymentMethod::where('user_id', $request->user()->id)->findOrFail($id);
        $pm->delete();
        return response()->noContent();
    }
}
