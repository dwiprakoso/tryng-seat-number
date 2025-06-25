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
        return Buyer::orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'No HP',
            'Instagram',
            'Alamat',
            'Kode Pos',
            'Ukuran Jersey',
            'Waktu Pemesanan',
        ];
    }

    public function map($buyer): array
    {
        static $no = 1;

        return [
            $no++,
            $buyer->nama_lengkap,
            $buyer->no_handphone,
            $buyer->nama_instagram,
            $buyer->alamat_lengkap,
            $buyer->kode_pos,
            $buyer->ukuran_jersey,
            $buyer->created_at->translatedFormat('l, d F Y'),
        ];
    }
}
