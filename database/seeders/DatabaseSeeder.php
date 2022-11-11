<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            'nama' => 'Churum Nizar A.Md',
            'nip' => '112233',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'slug' => 'churum-nizar-a-md',
            'remember_token' => Str::random(10),
        ]);

        // $jam_mengajar = [
        //     [
        //         'jam_ke' => '1',
        //         'waktu' => '07:15 - 07:50'
        //     ],
        //     [
        //         'jam_ke' => '2',
        //         'waktu' => '07:50 - 08:25'
        //     ],
        //     [
        //         'jam_ke' => '3',
        //         'waktu' => '08:25 - 09:00'
        //     ],
        //     [
        //         'jam_ke' => '4',
        //         'waktu' => '09:00 - 09:35'
        //     ],
        //     [
        //         'jam_ke' => '5',
        //         'waktu' => '09:55 - 10:30'
        //     ],
        //     [
        //         'jam_ke' => '6',
        //         'waktu' => '10:30 - 11:05'
        //     ],
        //     [
        //         'jam_ke' => '7',
        //         'waktu' => '11:05 - 11:40'
        //     ],
        //     [
        //         'jam_ke' => '8',
        //         'waktu' => '11:40 - 12:15'
        //     ],
        //     [
        //         'jam_ke' => '9',
        //         'waktu' => '13:15 - 13:50'
        //     ],
        //     [
        //         'jam_ke' => '10',
        //         'waktu' => '13:50 - 14:25'
        //     ]
        // ];

        // \App\Models\JamMengajar::insert($jam_mengajar);

        $kelas = ['Kelas i', 'Kelas ii', 'Kelas iii', 'Kelas iv', 'Kelas v', 'Kelas vi'];

        for ($i = 0; $i < count($kelas); $i++) {
            \App\Models\Kelas::create([
                'nama_kelas' => $kelas[$i],
            ]);
        }
    }
}
