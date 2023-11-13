<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([UsersTableSeeder::class]);

        DB::table('obats')->insert([
            [
                'id'=>'1',
                'nama_obat'=> 'Acetosal Tab 80 mg',
                'satuan'=> 'ktk/100',
                'total_stok'=> 900
            ],
            [
                'id'=>'2',
                'nama_obat'=> 'Acetyl sistein',
                'satuan'=> 'ktk/100',
                'total_stok'=> 400
            ],
            [
                'id'=>'3',
                'nama_obat'=> 'Acetyl sistein',
                'satuan'=> 'ktk/60',
                'total_stok'=> 200
            ],
        ]);

        DB::table('stok_obats')->insert([
            [
                'id'=>'1',
                'id_obat'=> '1',
                'sisa_stok'=> 900,
                'expired'=>Carbon::parse('2025-01-01'),
                'created_at'=>Carbon::now()
            ],
            [
                'id'=>'2',
                'id_obat'=> '2',
                'sisa_stok'=> 400,
                'expired'=>Carbon::parse('2025-01-01'),
                'created_at'=>Carbon::now()
            ],
            [
                'id'=>'3',
                'id_obat'=> '3',
                'sisa_stok'=> 200,
                'expired'=>Carbon::parse('2025-01-01'),
                'created_at'=>Carbon::now()
            ],
        ]);

        DB::table('obat_masuks')->insert([
            [
                'id'=>'1',
                'id_pemasok' => '1',
                'jenis_surat_masuk' => 'SBBM',
                'created_at'=>Carbon::now()

            ],
            [
                'id'=>'2',
                'id_pemasok' => '1',
                'jenis_surat_masuk' => 'SBBM',
                'created_at'=>Carbon::now()

            ],
            [
                'id'=>'3',
                'id_pemasok' => '1',
                'jenis_surat_masuk' => 'SBBM',
                'created_at'=>Carbon::now()
            ],
        ]);

        DB::table('detail_obat_masuks')->insert([
            [
                'id'=>'1',
                'id_obat_masuk'=>'1',
                'id_obat'=> '1',
                'jumlah'=> 1000,
                'expired'=>Carbon::parse('2025-01-01'),
                'created_at'=>Carbon::now()

            ],
            [
                'id'=>'2',
                'id_obat_masuk'=>'2',
                'id_obat'=> '2',
                'jumlah'=> 500,
                'expired'=>Carbon::parse('2025-01-01'),
                'created_at'=>Carbon::now()
            ],
            [
                'id'=>'3',
                'id_obat_masuk' => '3',
                'id_obat'=> '3',
                'jumlah'=> 260,
                'expired'=>Carbon::parse('2025-01-01'),
                'created_at'=>Carbon::now()
            ],
        ]);

        DB::table('pemasoks')->insert([
            [
                'id'=>'1',
                'nama_pemasok'=> 'Kimia Farma',
                'lokasi'=> 'Padang',
                'created_at'=>Carbon::now()
            ],
        ]);

        DB::table('obat_keluars')->insert([
            [
                'id'=>'1',
                'id_puskesmas' => '1',
                'id_jenis_keluar' => '1',
                'created_at'=>Carbon::now()

            ],
            [
                'id'=>'2',
                'id_puskesmas' => '8',
                'id_jenis_keluar' => '1',
                'created_at'=>Carbon::now()

            ],
            [
                'id'=>'3',
                'id_puskesmas' => '8',
                'id_jenis_keluar' => '1',
                'created_at'=>Carbon::now()

            ],
        ]);
        DB::table('detail_obat_keluars')->insert([
            [
                'id'=>'1',
                'id_obat_keluar'=>'1',
                'id_stok'=>'1',
                'id_obat'=> '1',
                'jumlah'=> 100,
                'sisa_stok'=> 100,
                'expired'=>Carbon::parse('2025-01-01'),
                'created_at'=>Carbon::now()

            ],
            [
                'id'=>'2',
                'id_obat_keluar'=>'2',
                'id_stok'=>'2',
                'id_obat'=> '2',
                'jumlah'=> 100,
                'sisa_stok'=> 80,
                'expired'=>Carbon::parse('2025-01-01'),
                'created_at'=>Carbon::now()
            ],
            [
                'id'=>'3',
                'id_obat_keluar' => '3',
                'id_stok'=>'3',
                'id_obat'=> '3',
                'jumlah'=> 60,
                'sisa_stok'=> 60,
                'expired'=>Carbon::parse('2025-01-01'),
                'created_at'=>Carbon::now()
            ],
        ]);
        DB::table('keluar_puskesmas')->insert([
            'id_puskesmas'=>'8',
            'id_detail_obat_keluar'=> '2',
            'jumlah' => 20,
            'keterangan'=>'Untuk Poli Gigi',
            'created_at'=>Carbon::now()
        ]);

        DB::table('puskesmas')->insert([
            [
                'id'=>'1',
                'nama_puskesmas'=> 'Puskesmas Pangkalan',
                'alamat'=> 'Pangkalan',
                'no_telp'=>'0210001'
,                'slug'=>'PKL'
            ],
            [
                'id'=>'2',
                'nama_puskesmas'=> 'Puskesmas Rimbo Data',
                'alamat'=> 'Rimbo Data',
                'no_telp'=>'0210002'
,                'slug'=>'RD'
            ],
            [
                'id'=>'3',
                'nama_puskesmas'=> 'Puskesmas Taram',
                'alamat'=> 'Taram',
                'no_telp'=>'021003'
 ,               'slug'=>'TRM'
            ],
            [
                'id'=>'4',
                'nama_puskesmas'=> 'Puskesmas Baruh Gunung',
                'alamat'=> 'Baruh Gunung',
                'no_telp'=>'0210004'
,                'slug'=>'BG'
            ],
            [
                'id'=>'5',
                'nama_puskesmas'=> 'Puskesmas Halaban',
                'alamat'=> 'Lareh Sago Halaban',
                'no_telp'=>'02100005',
                'slug'=>'HLB'
            ],
            [
                'id'=>'6',
                'nama_puskesmas'=> 'Puskesmas Koto Tinggi',
                'alamat'=> 'Koto Tinggo',
                'no_telp'=>'0210006'
,                'slug'=>'KT'
            ],
            [
                'id'=>'7',
                'nama_puskesmas'=> 'Puskesmas Pakan Rabaa',
                'alamat'=> 'Pakan Rabaa',
                'no_telp'=>'0210007'
,                'slug'=>'PRB'
            ],
            [
                'id'=>'8',
                'nama_puskesmas'=> 'Puskesmas Dangung-Dangung',
                'alamat'=> 'Jln. Tan Malaka Km. 15 Guguak VIII Koto',
                'no_telp'=>'0218731'
,                'slug'=>'DD'
            ],
            [
                'id'=>'9',
                'nama_puskesmas'=> 'Puskesmas Sialang',
                'alamat'=> 'Sialang',
                'no_telp'=>'0210009'
,                'slug'=>'SLG'
            ],
            [
                'id'=>'10',
                'nama_puskesmas'=> 'Puskesmas Padang Kandis',
                'alamat'=> 'Padang Kandis',
                'no_telp'=>'02100010',
                'slug'=>'PDK'
            ],
            [
                'id'=>'11',
                'nama_puskesmas'=> 'Puskesmas Mungo',
                'alamat'=> 'Mungo',
                'no_telp'=>'02100011',
                'slug'=>'MG'
            ],
            [
                'id'=>'12',
                'nama_puskesmas'=> 'Puskesmas Koto Baru Simalanggang',
                'alamat'=> 'Koto Baru Simalanggang',
                'no_telp'=>'02100012',
                'slug'=>'KBS'
            ],
            [
                'id'=>'13',
                'nama_puskesmas'=> 'Puskesmas Muaro Paiti',
                'alamat'=> 'Muaro Paiti',
                'no_telp'=>'02100013',
                'slug'=>'MP'
            ],
            [
                'id'=>'14',
                'nama_puskesmas'=> 'Puskesmas Mungka',
                'alamat'=> 'Mungka',
                'no_telp'=>'02100014',
                'slug'=>'MK'
            ],
            [
                'id'=>'15',
                'nama_puskesmas'=> 'Puskesmas Batu Hampar',
                'alamat'=> 'Batu Hampar',
                'no_telp'=>'02100014',
                'slug'=>'BTH'
            ],
            [
                'id'=>'16',
                'nama_puskesmas'=> 'Puskesmas Tanjung Pati',
                'alamat'=> 'Tanjung Pati',
                'no_telp'=>'02100016',
                'slug'=>'TP'
            ],
            [
                'id'=>'17',
                'nama_puskesmas'=> 'Puskesmas Suliki',
                'alamat'=> 'Suliki',
                'no_telp'=>'0210017'
,                'slug'=>'SLK'
            ],
            [
                'id'=>'18',
                'nama_puskesmas'=> 'Puskesmas Situjuh',
                'alamat'=> 'Situjuh',
                'no_telp'=>'02100018',
                'slug'=>'STJ'
            ],
            [
                'id'=>'19',
                'nama_puskesmas'=> 'Puskesmas Piladang',
                'alamat'=> 'Piladang',
                'no_telp'=>'02100019',
                'slug'=>'PLD'
            ],
            [
                'id'=>'20',
                'nama_puskesmas'=> 'Puskesmas Mahat',
                'alamat'=> 'Mahat',
                'no_telp'=>'02100020',
                'slug'=>'MHT'
            ],
            [
                'id'=>'21',
                'nama_puskesmas'=> 'Puskesmas Banja Loweh',
                'alamat'=> 'Banja Loweh',
                'no_telp'=>'02100021',
                'slug'=>'BL'
            ],
            [
                'id'=>'22',
                'nama_puskesmas'=> 'Puskesmas Gunung Malintang',
                'alamat'=> 'Gunung Malintang',
                'no_telp'=>'02100022',
                'slug'=>'GM'
            ],
            [
                'id'=>'23',
                'nama_puskesmas'=> 'Instalasi Farmasi Kabupaten',
                'alamat'=> 'Tanjung Pati',
                'no_telp'=>'02100023',
                'slug'=>'IFK'
            ],
            [
                'id'=>'24',
                'nama_puskesmas'=> 'Dinas Kesehatan Kabupaten',
                'alamat'=> 'Dinkes Kab',
                'no_telp'=>'0210024',
                'slug'=>'DINKES'
            ],
        ]);

        DB::table('jenis_keluars')->insert([
            [
                'id'=>'1',
                'nama_jenis_keluar'=> 'Pengeluaran ke Puskesmas'
            ],
            [
                'id'=>'2',
                'nama_jenis_keluar'=> 'Pemusnahan obat kadaluwarsa'
            ],
            [
                'id'=>'3',
                'nama_jenis_keluar'=> 'Perpanjangan kadaluarsa'
            ],
        ]);
    }
}
