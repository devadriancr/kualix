<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Area::create([
            'name' => 'Poka-Yoke',
            'description' => 'Area dedicated to implementing Poka-Yoke systems to prevent errors in manufacturing processes.',
            'department_id' => Department::where('name', 'Calidad')->first()->id,
        ]);

        Area::create([
            'name' => 'Servicio al Cliente',
            'description' => 'Area focused on customer service and support, ensuring customer satisfaction and handling inquiries.',
            'department_id'=> Department::where('name', 'Calidad')->first()->id,
        ]);
    }
}
