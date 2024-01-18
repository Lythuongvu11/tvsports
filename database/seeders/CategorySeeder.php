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
        Category::insert([
            [
                'name'=> 'Bóng đá',
                'parent_id'=> null
            ],
            [
                'name'=> 'Tennis',
                'parent_id'=> null
            ],
            [
                'name'=> 'Bóng rổ',
                'parent_id'=> null
            ],
            [
                'name'=> 'Cầu lông',
                'parent_id'=> null
            ],
            [
                'name'=> 'Bóng chuyền',
                'parent_id'=> null
            ],
            [
                'name'=> 'Chạy bộ',
                'parent_id'=> null
            ],
            [
                'name'=> 'Gym',
                'parent_id'=> null
            ],
        ]);
    }
}
