<?php

namespace App\Exports;

use App\Models\Buyer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\Storage;

class BuyerExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths, WithStyles
{
    protected $buyers;

    public function __construct()
    {
        $this->buyers = Buyer::with(['ticket', 'seats'])->orderBy('created_at', 'asc')->get();
    }

    public function collection()
    {
        return $this->buyers;
    }

    public function headings(): array
    {
        return [
            'No',
            'ID Pesanan',
            'Nama Lengkap',
            'Email',
            'No HP',
            'Kategori Tiket',
            'Jumlah',
            'Kursi',
            'Status Pembayaran',
            'Tanggal Pemesanan',
            'Jam Pemesanan',
            'Harga Tiket',
            'Payment Code',
            'Total Harga',
        ];
    }

    public function map($buyer): array
    {
        static $no = 1;

        // Format nomor kursi
        $seatNumbers = $buyer->seats->count() > 0
            ? $buyer->seats->pluck('seat_number')->sort()->implode(', ')
            : 'Belum dipilih';

        return [
            $no++,
            $buyer->external_id,
            $buyer->nama_lengkap,
            $buyer->email,
            $buyer->no_handphone,
            $buyer->ticket->name,
            $buyer->quantity,
            $seatNumbers,
            ucfirst(str_replace('_', ' ', $buyer->payment_status)),
            $buyer->created_at->format('d/m/Y'),
            $buyer->created_at->format('H:i'),
            $buyer->ticket_price,
            $buyer->payment_code ?? '-',
            $buyer->total_amount,
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,   // No
            'B' => 20,  // ID Pesanan
            'C' => 25,  // Nama Lengkap
            'D' => 25,  // Email
            'E' => 15,  // No HP
            'F' => 20,  // Kategori Tiket
            'G' => 8,   // Jumlah
            'H' => 15,  // Kursi
            'I' => 18,  // Status Pembayaran
            'J' => 15,  // Tanggal Pemesanan
            'K' => 10,  // Jam Pemesanan
            'L' => 12,  // Harga Tiket
            'M' => 12,  // Unique Code
            'N' => 12,  // Total Harga
            'O' => 15,  // Kode Pembayaran
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Set row height untuk header
        $sheet->getRowDimension('1')->setRowHeight(30);

        // Set row height untuk semua baris data
        $totalRows = $this->buyers->count() + 1; // +1 untuk header
        for ($row = 2; $row <= $totalRows; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(25);
        }

        // Style untuk header
        $sheet->getStyle('A1:N1')->getFont()->setBold(true);
        $sheet->getStyle('A1:N1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('CCCCCC');

        // Center align untuk kolom tertentu
        $sheet->getStyle('A1:A' . $totalRows)->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('G1:G' . $totalRows)->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('H1:H' . $totalRows)->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('I1:I' . $totalRows)->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('J1:K' . $totalRows)->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Format currency untuk kolom harga
        $sheet->getStyle('L2:N' . $totalRows)->getNumberFormat()
            ->setFormatCode('#,##0');

        return [];
    }
}
