<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Faker\Factory as Faker;

class Siswa_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        for ($i=1; $i <= 20 ; $i++) {
            DB::table('siswa')->insert([
                'nama'      => $faker->name,
                'alamat'    => $faker->address,
                'kelas_id'  => $faker->numberBetween(1,3),
                'status'    => $faker->numberBetween(0,1),
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ]);
        }
    }
}
