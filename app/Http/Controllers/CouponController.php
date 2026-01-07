<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function validateCoupon(Request $request)
    {
        $request->validate(['code' => 'required']);
        $coupon = Coupon::where('code', $request->code)
            ->where(function($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })->first();
        if (!$coupon) {
            return response()->json(['valid' => false, 'message' => 'Cupón inválido o expirado'], 404);
        }
        return response()->json(['valid' => true, 'coupon' => $coupon]);
    }
}
