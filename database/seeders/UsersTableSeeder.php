<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            ['name' => 'Ringgo',
            'email' => 'ringgoagsya12@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('ringgo'),
            'level' => 'admin',
            'id_pus' => '23',
            'created_at' => now(),
            'updated_at' => now()
            ],
            ['name' => 'Puskesmas DD',
            'email' => 'puskesmasdd@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('puskesmas'),
            'level' => 'user',
            'id_pus' => '8',
            'created_at' => now(),
            'updated_at' => now()
             ],


        ]);
    }
}
