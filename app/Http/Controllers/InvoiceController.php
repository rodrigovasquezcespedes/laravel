<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Order;

class InvoiceController extends Controller
{
    public function download($orderId)
    {
        $order = Order::findOrFail($orderId);
        $pdf = Pdf::loadView('invoices.pdf', compact('order'));
        return $pdf->download("invoice-{$order->id}.pdf");
    }
}
