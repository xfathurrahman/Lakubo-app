<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\StoreTransaction;
use Illuminate\Console\Command;

class ConfirmOrderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:confirm-order-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Ambil pesanan yang belum dikonfirmasi setelah 3 hari
        $orders = Order::query()
            ->where('status', '!=', 'completed')
            ->whereDate('created_at', '<=', now()->subMinutes(1))
            ->get();

        foreach ($orders as $order) {
            // Ubah status pesanan menjadi completed
            $order->status = 'completed';
            $order->update();

            // Tambahkan grand total ke saldo toko
            $store = $order->stores;
            $store->balance += $order->grand_total;
            $store->update();

            // Tambahkan transaksi ke store transaction
            StoreTransaction::create([
                'store_id' => $order->stores->id,
                'order_id' => $order->id,
                'amount' => $order->grand_total,
                'payment_method' => $order->payment_type ?? null,
                'payment_type' => 'selling',
            ]);
        }
    }

}
