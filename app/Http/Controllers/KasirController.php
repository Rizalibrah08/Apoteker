<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obat;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KasirController extends Controller
{
    public function index()
    {
        $obats = Obat::all();
        return view('backend.kasir.index', compact('obats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cart' => 'required|array',
            'total_bayar' => 'required|integer',
        ]);

        try {
            DB::beginTransaction();

            // 0. Pre-check Stock Availability
            foreach ($request->cart as $item) {
                $obat = Obat::find($item['id']);
                if (!$obat) {
                    throw new \Exception("Obat {$item['name']} tidak ditemukan.");
                }
                if ($obat->stok < $item['qty']) {
                    throw new \Exception("Stok {$item['name']} tidak mencukupi! Sisa: {$obat->stok}, Diminta: {$item['qty']}");
                }
            }

            // 1. Create Transaction
            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                'no_transaksi' => 'TRX-' . date('YmdHis'),
                'total_bayar' => $request->total_bayar,
            ]);

            // 2. Create Transaction Items & Update Stock
            foreach ($request->cart as $item) {
                // Re-fetch to lock/ensure (optimistic for now as we are single instance)
                $obat = Obat::find($item['id']);

                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'obat_id' => $item['id'],
                    'nama_obat' => $item['name'],
                    'harga' => $item['price'],
                    'qty' => $item['qty'],
                    'subtotal' => $item['price'] * $item['qty'],
                ]);

                // Update Stock (Decrement)
                $obat->decrement('stok', $item['qty']);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil!',
                'transaction_id' => $transaction->id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage() // Return friendly error message
            ], 400); // 400 Bad Request for logic errors
        }
    }
}
