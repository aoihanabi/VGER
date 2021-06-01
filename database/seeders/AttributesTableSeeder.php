<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Attribute::create([
            'name' => 'Color'
        ]);
        Attribute::create([
            'name' => 'Talla'
        ]);
        Attribute::create([
            'name' => 'Estilo'
        ]);
    }
}
