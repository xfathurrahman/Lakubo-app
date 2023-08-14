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
use Maatwebsite\Excel\Concerns\Exportable;

class OrdersExport implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting
{
    use Exportable;

    private $seller;

    public function __construct($seller)
    {
        $this->seller = $seller;
    }

    public function collection()
    {
        $seller_id = $this->seller->id;

        $statusConversions = [
            'completed' => 'selesai',
            'awaiting_confirm' => 'menunggu konfirmasi',
            'confirmed' => 'dikonfirmasi',
            'packing' => 'dikemas',
            'delivered' => 'dikirim',
            'cancelled' => 'dibatalkan',
        ];

        $orders = Order::query()
            ->with('orderShipping', 'orderItems.products')
            ->where('store_id', $seller_id)
            ->whereNotIn('status', ['choosing_payment', 'awaiting_payment'])
            ->orderBy('created_at', 'asc')
            ->select('id', 'customer_name', 'status', 'grand_total')
            ->get();

        foreach ($orders as $order) {
            $order->status = $statusConversions[$order->status] ?? $order->status;
            $products = $order->orderItems->map(function ($orderItem) {
                return $orderItem->products->name . ' (' . $orderItem->quantity . ')';
            })->implode("\n");
            $order->products = $products;
            $order->service = $order->orderShipping->service ?? null;
            $order->tracking_number = $order->orderShipping->tracking_number ?? null;
            $order->grand_total_formatted = 'Rp ' . number_format($order->grand_total, 2, ',', '.');
        }

        return $orders->map(function ($order) {
            return [
                $order->id,
                $order->customer_name,
                $order->status,
                $order->products,
                $order->service,
                $order->tracking_number,
                $order->grand_total_formatted,
            ];
        });

        return $orders;
    }

    public function headings(): array
    {
        return [
            'ID Pesanan',
            'Nama Pelanggan',
            'Status Pesanan',
            'Produk & Kuantitas',
            'Layanan Pengiriman',
            'Resi Pengiriman',
            'Total Tagihan',
        ];
    }    

    public function columnFormats(): array
    {
        return [
            'A' => '@',
            'F' => '@',
            'E' => NumberFormat::FORMAT_TEXT,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('E2:E')->getAlignment()->setWrapText(true);
                $event->sheet->getStyle('E2:E')->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
                $event->sheet->getDefaultRowDimension()->setRowHeight(-1);
    
                $highestRow = $event->sheet->getHighestRow();
                $sheet = $event->sheet->getDelegate();
    
                // Mengatur tinggi sel pada kolom "Produk & Kuantitas" agar menyesuaikan tinggi baris kalimat nama produk
                for ($row = 2; $row <= $highestRow; $row++) {
                    $cellValue = $sheet->getCell('D' . $row)->getValue();
                    $numLines = substr_count($cellValue, "\n") + 1;
    
                    $event->sheet->getRowDimension($row)->setRowHeight($numLines * 15); // Sesuaikan tinggi baris sesuai kebutuhan Anda
    
                    $productCell = $sheet->getCell('D' . $row);
                    $productCell->getStyle()->getAlignment()->setWrapText(true);
                }
    
                for ($row = 2; $row <= $highestRow; $row++) {
                    $event->sheet->getStyle('A' . $row)
                        ->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_LEFT);
                }
            },
        ];
    }
}
