<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = Category::where('name', 'Remessa Parcial')->first();
        if(!$category) {
            DB::table('categories')->insert([
                'name' => 'Remessa Parcial'
            ]);
        }

        $category2 = Category::where('name', 'Remessa')->first();
        if(!$category2) {
            DB::table('categories')->insert([
                'name' => 'Remessa'
            ]);
        }
    }
}
