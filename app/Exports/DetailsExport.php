<?php

namespace App\Exports;

use App\Models\Asset;
use App\Models\Host;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DetailsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    public function collection()
    {
        if (auth()->user()->role == 1) {
            $assets = Asset::with(['tuanRumah', 'hostAssetHistories' => function ($query) {
                $query->latest();
            }, 'assetWilayah'])->get();
        } else {
            $assets = Asset::with(['tuanRumah', 'hostAssetHistories' => function ($query) {
                $query->latest();
            }, 'assetWilayah'])->where('wilayah_id', auth()->user()->wilayah_id)->get();
        }

        return $assets;
    }

    public function map($assets): array
    {
        $host = $assets->tuanRumah;
        $latestHostHistory = $assets->hostAssetHistories->first();

        Log::info('Asset:', $assets->toArray());
        Log::info('Host:', $host ? $host->toArray() : ['No Host']);
        Log::info('Latest Host History:', $latestHostHistory ? $latestHostHistory->toArray() : ['No History']);

        return [
            $assets->kode_aset,
            $assets->nama_aset,
            $assets->alamat,
            $assets->jenis_aset,
            $assets->assetWilayah ? $assets->assetWilayah->nama_wilayah : '-',
            $latestHostHistory ? $latestHostHistory->host->nama_penyewa : '-',
            $latestHostHistory ? $latestHostHistory->host->no_ktp : '-',
            $latestHostHistory ? $latestHostHistory->host->no_tlp : '-',
            $latestHostHistory ? $latestHostHistory->harga_sewa : '-',
        ];
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
            'Harga Sewa'
        ];
    }
}
