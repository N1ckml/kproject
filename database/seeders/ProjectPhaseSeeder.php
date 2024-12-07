<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Phase;
use App\Models\Project;

class ProjectPhaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Crear un proyecto con 4 fases
        $project1 = Project::factory()->create();
        Phase::factory(4)->create(['project_id' => $project1->id]);

        // Crear un proyecto con 5 fases
        $project2 = Project::factory()->create();
        Phase::factory(5)->create(['project_id' => $project2->id]);
    }
}
