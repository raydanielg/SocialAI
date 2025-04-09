<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class CoingateCallbackController extends Controller
{

    public function orderCallback(Request $request, string $oderId)
    {
        $order = Order::find($oderId);
        $order->update([
            'payment_status' => $request->status
        ]);

        return response()->json(['success' => true]);
    }
}
