<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;

class MidtransController extends Controller
{
    public function makePayment(Request $request)
    {
        // Midtrans config
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // ===== VALIDASI DULU =========
        if (!$request->total || !$request->cart) {
            return response()->json([
                'error' => 'Missing total or cart data'
            ], 400);
        }

        // ===== SETUP ORDER =============
        $params = [
            'transaction_details' => [
                'order_id' => 'KKM-' . time(),
                'gross_amount' => (int) $request->total,
            ],
            'item_details' => array_map(function ($item) {
                return [
                    'id'       => $item['id'],
                    'price'    => (int) $item['price'],
                    'quantity' => (int) $item['qty'],
                    'name'     => $item['name'],
                ];
            }, $request->cart),

            'customer_details' => [
                'first_name' => 'Customer',
                'email'      => 'customer@mail.com',
            ],
        ];

        // ===== Generate SnapToken ======
        $snapToken = Snap::getSnapToken($params);

        return response()->json([
            'snap_token' => $snapToken
        ]);
    }
}
