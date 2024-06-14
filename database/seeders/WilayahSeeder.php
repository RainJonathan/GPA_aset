<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class WilayahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('wilayahs')->insert([
            [
                'id' => 1,
                'nama_wilayah' => 'Semua Wilayah',
                'kode_pos' => '00000',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 2,
                'nama_wilayah' => 'Tanah Abang - Jakarta Pusat',
                'kode_pos' => '10230',
                'created_at' => Carbon::create('2024', '05', '20', '08', '19', '28'),
                'updated_at' => Carbon::create('2024', '05', '21', '00', '19', '11'),
            ],
            [
                'id' => 3,
                'nama_wilayah' => 'Pulo Gadung - Jakarta Timur',
                'kode_pos' => '13260',
                'created_at' => Carbon::create('2024', '05', '20', '08', '21', '32'),
                'updated_at' => Carbon::create('2024', '05', '21', '00', '19', '26'),
            ],
            [
                'id' => 4,
                'nama_wilayah' => 'Serpong - Tanggerang Selatan',
                'kode_pos' => '15322',
                'created_at' => Carbon::create('2024', '05', '21', '00', '18', '49'),
                'updated_at' => Carbon::create('2024', '05', '21', '00', '18', '49'),
            ],
            [
                'id' => 5,
                'nama_wilayah' => 'Cibinong - Bogor',
                'kode_pos' => '16912',
                'created_at' => Carbon::create('2024', '05', '21', '00', '20', '30'),
                'updated_at' => Carbon::create('2024', '05', '21', '00', '20', '30'),
            ],
            [
                'id' => 6,
                'nama_wilayah' => 'Petukangan Selatan - Jakarta Selatan',
                'kode_pos' => '12270',
                'created_at' => Carbon::create('2024', '05', '21', '00', '22', '51'),
                'updated_at' => Carbon::create('2024', '05', '21', '00', '22', '51'),
            ],
            [
                'id' => 7,
                'nama_wilayah' => 'Pondok Kopi - Jakarta Timur',
                'kode_pos' => '13460',
                'created_at' => Carbon::create('2024', '05', '21', '00', '23', '43'),
                'updated_at' => Carbon::create('2024', '05', '21', '00', '23', '43'),
            ],
            [
                'id' => 8,
                'nama_wilayah' => 'Cimanggis - Depok',
                'kode_pos' => '13740',
                'created_at' => Carbon::create('2024', '05', '21', '00', '25', '58'),
                'updated_at' => Carbon::create('2024', '05', '21', '00', '25', '58'),
            ],
            [
                'id' => 9,
                'nama_wilayah' => 'Cinere - Depok',
                'kode_pos' => '16514',
                'created_at' => Carbon::create('2024', '05', '21', '00', '27', '02'),
                'updated_at' => Carbon::create('2024', '05', '21', '00', '27', '02'),
            ],
            [
                'id' => 10,
                'nama_wilayah' => 'Jagakarsa - Jakarta Selatan',
                'kode_pos' => '12620',
                'created_at' => Carbon::create('2024', '05', '21', '00', '27', '52'),
                'updated_at' => Carbon::create('2024', '05', '21', '00', '27', '52'),
            ],
            [
                'id' => 11,
                'nama_wilayah' => 'Bojong Nangka - Tanggerang',
                'kode_pos' => '15811',
                'created_at' => Carbon::create('2024', '05', '21', '00', '30', '27'),
                'updated_at' => Carbon::create('2024', '05', '21', '00', '30', '27'),
            ],
            [
                'id' => 12,
                'nama_wilayah' => 'Duren Sawit - Jakarta Timur',
                'kode_pos' => '13440',
                'created_at' => Carbon::create('2024', '05', '21', '00', '31', '30'),
                'updated_at' => Carbon::create('2024', '05', '21', '00', '31', '30'),
            ],
            [
                'id' => 13,
                'nama_wilayah' => 'Setia Mekar - Bekasi',
                'kode_pos' => '17510',
                'created_at' => Carbon::create('2024', '05', '21', '00', '32', '23'),
                'updated_at' => Carbon::create('2024', '05', '21', '00', '32', '23'),
            ],
            [
                'id' => 14,
                'nama_wilayah' => 'Cikini Menteng - Jakarta Pusat',
                'kode_pos' => '10330',
                'created_at' => Carbon::create('2024', '05', '21', '00', '33', '13'),
                'updated_at' => Carbon::create('2024', '05', '21', '00', '33', '13'),
            ],
            [
                'id' => 15,
                'nama_wilayah' => 'Cikarang Selatan - Bekasi Barat',
                'kode_pos' => '17532',
                'created_at' => Carbon::create('2024', '05', '21', '01', '24', '24'),
                'updated_at' => Carbon::create('2024', '05', '21', '01', '24', '24'),
            ],
            [
                'id' => 16,
                'nama_wilayah' => 'Tanjung Pinang Barat - Kepulauan Riau',
                'kode_pos' => '29113',
                'created_at' => Carbon::create('2024', '05', '21', '01', '25', '48'),
                'updated_at' => Carbon::create('2024', '05', '21', '01', '25', '48'),
            ],
        ]);
    }
}
