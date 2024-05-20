<?php

namespace App\Exports;

use App\Models\Asset;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DetailsExport implements FromCollection, WithHeadings, ShouldAutoSize
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
                'Kode Aset' => $asset->kode_aset,
                'Nama Aset' => $asset->nama_aset,
                'Alamat Aset' => $asset->alamat,
                'Jenis Aset' => $asset->jenis_aset,
                'Wilayah' => $asset->wilayah,
                'Penghuni Sekarang' => $asset->tuanRumah ? $asset->tuanRumah->nama_penyewa : '-',
                'No.KTP' => $asset->tuanRumah ? $asset->tuanRumah->no_ktp: '-',
                'No.Hp' => $asset->tuanRumah ? $asset->tuanRumah->no_tlp : '-',
                // 'Bank Pembayaran' => $asset->tuanRumah ? $asset->tuanRumah->bank_pembayaran :'-',
                'Status Aktif' => $asset->tuanRumah ? ($asset->tuanRumah->aktif === 0 ? 'Tidak Aktif' : 'Aktif') : '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Kode Aset',
            'Nama Aset',
            'Alamat Aset',
            'Jenis Aset',
            'Wilayah',
            'Penghuni Sekarang',
            'No.KTP',
            'No.Hp',
            // 'Bank Pembayaran',
            'Status Aktif'
        ];
    }
}

