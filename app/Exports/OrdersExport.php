<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class OrdersExport implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting
{
    public function collection()
    {
        $seller_id = auth()->user()->stores->first()->id;

        return Order::query()
            ->where('store_id', $seller_id)
            ->whereNotIn('status', ['choosing_payment', 'awaiting_payment'])
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($order) {
                $status = $order->status;
                if ($status === 'completed') {
                    $status = 'selesai';
                } elseif ($status === 'awaiting_confirm') {
                    $status = 'menunggu konfirmasi';
                } elseif ($status === 'confirmed') {
                    $status = 'dikonfirmasi';
                } elseif ($status === 'packing') {
                    $status = 'dikemas';
                } elseif ($status === 'delivered') {
                    $status = 'dikirim';
                } elseif ($status === 'cancelled') {
                    $status = 'dibatalkan';
                }
                return [
                    $order->id,
                    $order->customer_name,
                    $status,
                    $order->orderItems->map(function ($item) {
                        return $item->products->name . ' (' . $item->quantity . ')';
                    })->implode("\n"), // Menggunakan "\n" untuk memulai produk pada baris baru
                    $order->orderShipping->service,
                    $order->orderShipping->tracking_number,
                    'Rp ' . number_format($order->grand_total, 2, ',', '.'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID Pesanan',
            'Nama Pelanggan',
            'Status Pesanan',
            'Produk',
            'Layanan Pengiriman',
            'Resi',
            'Total Tagihan',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => '@',
            'D' => '@',
            'E' => NumberFormat::FORMAT_TEXT,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('E2:E')->getAlignment()->setWrapText(true);
                $event->sheet->getStyle('E2:E')->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
                $event->sheet->getDefaultRowDimension()->setRowHeight(-1); // Menyesuaikan tinggi baris secara otomatis

                $highestRow = $event->sheet->getHighestRow();
                for ($row = 2; $row <= $highestRow; $row++) {
                    $event->sheet->getStyle('A' . $row)
                        ->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_LEFT);
                }
            },
        ];
    }
}



