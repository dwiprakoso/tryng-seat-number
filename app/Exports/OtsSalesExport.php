<?php

namespace App\Exports;

use App\Models\OtsSales;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OtsSalesExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths, WithStyles
{
    protected $otsSales;

    public function __construct()
    {
        $this->otsSales = OtsSales::with('ticket')->orderBy('created_at', 'asc')->get();
    }

    public function collection()
    {
        return $this->otsSales;
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Lengkap',
            'No. Handphone',
            'Kategori Tiket',
            'Harga Tiket',
            'Jumlah',
            'Subtotal',
            'Biaya Admin',
            'Total Harga',
            'Metode Pembayaran',
            'Tanggal Penjualan',
        ];
    }

    public function map($otsSale): array
    {
        static $no = 1;

        return [
            $no++,
            $otsSale->nama_lengkap,
            $otsSale->no_handphone,
            $otsSale->ticket->name,
            'Rp ' . number_format($otsSale->ticket_price, 0, ',', '.'),
            $otsSale->quantity,
            'Rp ' . number_format($otsSale->ticket_price * $otsSale->quantity, 0, ',', '.'),
            'Rp ' . number_format($otsSale->admin_fee, 0, ',', '.'),
            'Rp ' . number_format($otsSale->total_amount, 0, ',', '.'),
            ucfirst($otsSale->payment_method),
            $otsSale->created_at->translatedFormat('l, d F Y H:i'),
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,   // No
            'B' => 25,  // Nama Lengkap
            'C' => 15,  // No. Handphone
            'D' => 20,  // Kategori Tiket
            'E' => 15,  // Harga Tiket
            'F' => 8,   // Jumlah
            'G' => 15,  // Subtotal
            'H' => 12,  // Biaya Admin
            'I' => 15,  // Total Harga
            'J' => 15,  // Metode Pembayaran
            'K' => 25,  // Tanggal Penjualan
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Set row height untuk header
        $sheet->getRowDimension('1')->setRowHeight(30);

        // Set row height untuk semua baris data
        $totalRows = $this->otsSales->count() + 1; // +1 untuk header
        for ($row = 2; $row <= $totalRows; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(25);
        }

        // Style untuk header
        $sheet->getStyle('A1:K1')->getFont()->setBold(true);
        $sheet->getStyle('A1:K1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('CCCCCC');

        // Center align untuk semua cells
        $sheet->getStyle('A1:K' . $totalRows)->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        return [];
    }
}
