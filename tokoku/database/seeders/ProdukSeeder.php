<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 5; $i++) {
            $produk = new Produk();

            $produk->nama_produk = $faker->nama_produk;
            $produk->merk = $faker->merk;

            $produk->save();
        }
    }
}
