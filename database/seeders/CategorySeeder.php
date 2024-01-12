<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Breakfast',
                'Meal' ,
                'Soup',
                'Slad',
                'Vegetable',
                'Dessert'
        ];
        
        foreach($data as $value)
        {
            Category::create([
                'category'=>$value
            ]);
        }
    }
}
