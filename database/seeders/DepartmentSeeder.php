<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::create([
            'name' => 'Estampado',
            'description' => 'Responsible for the stamping and shaping of metal parts.',
        ]);

        Department::create([
            'name' => 'Carrocerías',
            'description' => 'Responsible for the design and manufacturing of vehicle bodies.',
        ]);

        Department::create([
            'name' => 'Chasis',
            'description' => 'Handles the construction and assembly of vehicle chassis.',
        ]);

        Department::create([
            'name' => 'Pintura',
            'description' => 'Specializes in the painting and finishing of vehicle surfaces.',
        ]);

        Department::create([
            'name' => 'Calidad',
            'description' => 'Ensures the quality standards of materials and processes.',
        ]);
    }
}
