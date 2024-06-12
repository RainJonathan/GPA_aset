<?php
namespace App\Exports;

use App\Models\Asset;
use App\Models\Host;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class AssetsExport implements FromCollection, WithHeadings ,ShouldAutoSize, WithStyles
{
    public function collection()
    {
        if (Auth()->user()->role == 1) {
            $assets = Asset::with(['tickets', 'pengeluaran', 'hostAssetHistories', 'hostAssetHistoriesMonthYear' => function ($query) {
                $query->latest();
            }])->get();
        } else {
            $assets = Asset::where('wilayah_id', Auth()->user()->wilayah_id)
                ->with(['tickets', 'pengeluaran', 'hostAssetHistories', 'hostAssetHistoriesMonthYear' => function ($query) {
                    $query->latest();
                }])
                ->get();
        }

        $index = 1;

        return $assets->map(function ($asset) use (&$index) {
            //untuk relation asset dan host
            $latestHistory = $asset->hostAssetHistories->first();
            $host = Host::where('asset_id', $asset->id)->first();

            //untuk ngitung laba-rugi
            $totalPendapatan = $asset->hostAssetHistoriesMonthYear->sum('harga_sewa');
            $pengeluaran = $asset->totalPengeluaran();
            
            
            $row = [
                'No.' => $index++,
                'Wilayah' => $asset->assetWilayah->nama_wilayah,
                'Nama Aset' => $asset->nama_aset,
                'Jenis Aset' => $asset->jenis_aset,
                'Kode Aset' => $asset->kode_aset,
                'Alamat Aset' => $asset->alamat,
                'Nama Penyewa' => $host ? $host->nama_penyewa : '-',
                'No KTP' => $host ? $host->no_ktp : '-',
                'No HP' => $host ? $host->no_tlp : '-',
                'Tanggal Masuk' =>$host ? $host->tgl_awal:'-',
                'Tanggal Keluar' => $host ? $host->tgl_akhir:'-',
                'Bank Pembayaran' => $latestHistory ? $latestHistory->bank_pembayaran : '-',
                'Harga Pembayaran' => $latestHistory ? 'Rp ' . str_replace(',', ',-', number_format($latestHistory->harga_pembayaran, 0, ',', '.')) : '-',
                'Status Penyewaan' => $latestHistory ? $latestHistory->status_penyewaan : '-',
                'Pendapatan' => 'Rp ' . str_replace(',', ',-', number_format($totalPendapatan, 0, ',', '.')),
                'Pengeluaran' => 'Rp ' . str_replace(',', ',-', number_format($pengeluaran, 0, ',', '.')),
                'Status Saldo' => $host ? ($host->saldo_piutang == 1 ? 'Lunas' : 'Tidak Lunas') : '-',
                'Status Aktif' => $host ? ($host->status_aktif == 1 ? 'Aktif' : 'Tidak Aktif') : '-',
                'Laba/Rugi' => 'Rp ' . str_replace(',', ',-', number_format($totalPendapatan - $pengeluaran, 0, ',', '.')),

            ];
            return $row;
        });
    }
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],  
        ];
    }

    public function headings(): array
    {
        return [
            'No.',
            'Wilayah',
            'Nama Aset',
            'Jenis Aset',
            'Kode Aset',
            'Alamat',
            'Penyewa',
            'No KTP',
            'No Telepon',
            'Tanggal Masuk',
            'Tanggal Keluar',
            'Bank Pembayaran',
            'Jumlah Pembayaran',
            'Status Penyewaan',
            'Pendapatan',
            'Pengeluaran',
            'Status Saldo',
            'Status Aktif',
            'Laba/Rugi'
        ];
    }
}
