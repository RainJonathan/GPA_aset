<?php
namespace App\Exports;

use App\Models\Asset;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AssetsExport implements FromCollection, WithHeadings ,ShouldAutoSize
{
    public function collection()
    {
        if(Auth()->user()->role == 1){
            $assets = Asset::all();
        }else{
            $assets = Asset::where('wilayah_id',Auth()->user()->wilayah_id)->get();
        }

        return $assets->map(function ($asset) {
            return [
                'Nama Aset' => $asset->nama_aset,
                'Kode Aset' => $asset->kode_aset,
                'Alamat Aset' => $asset->alamat,
                'Jenis Aset' => $asset->jenis_aset,
                'Wilayah' => $asset->assetWilayah->nama_wilayah,
                'Pendapatan' => 'Rp ' . str_replace(',', ',-', number_format($asset->tuanRumah ? $asset->tuanRumah->harga_sewa : 0, 0, ',', '.')),
                'Pengeluaran' => 'Rp ' . str_replace(',', ',-', number_format($asset->pengeluaran, 0, ',', '.')),

            ];
        });
    }


    public function headings(): array
    {
        return [
            'Nama Aset',
            'Kode Aset',
            'Alamat Aset',
            'Jenis Aset',
            'Wilayah',
            'Pendapatan',
            'Pengeluaran',
        ];
    }
}
