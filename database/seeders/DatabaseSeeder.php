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

        \App\Models\User::create([
            'nama' => 'Deva Agna Saputra S.Kom',
            'nip' => '121215',
            'email' => 'devaagna0909@gmail.com',
            'password' => bcrypt('09-04-1998'),
            'tanggal_lahir' => '1998-04-09',
            'role' => 'guru',
            'slug' => 'deva-agna-saputra-s-k-o-m',
            'remember_token' => Str::random(10),
        ]);

        $kelas = ['Kelas i', 'Kelas ii', 'Kelas iii', 'Kelas iv', 'Kelas v', 'Kelas vi'];

        for ($i = 0; $i < count($kelas); $i++) {
            \App\Models\Kelas::create([
                'nama_kelas' => $kelas[$i],
            ]);
        }
    }
}
