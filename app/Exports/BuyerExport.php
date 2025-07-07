<?php

namespace App\Exports;

use App\Models\Buyer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BuyerExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Buyer::with('ticket')->orderBy('created_at', 'asc')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'ID Pesanan',
            'Nama',
            'No HP',
            'Email',
            'Kategori Tiket',
            'Jumlah',
            'Waktu Pemesanan',
            'Status Pembayaran',
            'Link Pembayaran',
            'Harga Tiket',
            'Biaya Layanan',
            'Total Harga',
        ];
    }

    public function map($buyer): array
    {
        static $no = 1;

        return [
            $no++,
            $buyer->external_id,
            $buyer->nama_lengkap,
            $buyer->no_handphone,
            $buyer->email,
            $buyer->ticket->name,
            $buyer->quantity,
            $buyer->created_at->translatedFormat('l, d F Y'),
            $buyer->payment_status,
            $buyer->xendit_invoice_url,
            $buyer->ticket_price,
            $buyer->admin_fee,
            $buyer->total_amount,
        ];
    }
}
