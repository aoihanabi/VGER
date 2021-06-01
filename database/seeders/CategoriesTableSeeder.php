<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Hogar',
            'status' => 'A'
        ]);
        Category::create([
            'name' => 'Ferretería',
            'status' => 'A'
        ]);
        Category::create([
            'name' => 'Bazar',
            'status' => 'A'
        ]);
        Category::create([
            'name' => 'Tienda',
            'status' => 'A'
        ]);
        Category::create([
            'name' => 'Librería',
            'status' => 'A'
        ]);
        
    }
}
