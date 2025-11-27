<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;

class MidtransController extends Controller
{
    public function makePayment(Request $request)
    {
        // Setup Midtrans Config
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Data Order (bisa kamu ambil dari Cart)
        $params = [
            'transaction_details' => [
                'order_id' => rand(),
                'gross_amount' => $request->total,
            ],
            'customer_details' => [
                'first_name' => 'Customer',
                'email' => 'customer@mail.com',
            ],
        ];

        // Generate Snap Token
        $snapToken = Snap::getSnapToken($params);

        return response()->json([
            'snap_token' => $snapToken
        ]);
    }
}
