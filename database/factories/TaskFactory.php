<?php

namespace Database\Factories;


use App\Models\Project;
use App\Models\Phase;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;

    /**
     * Define the model's default state.
     */
        public function definition(): array
        {
            return [
                'project_id' => Project::inRandomOrder()->first()->id ?? Project::factory()->create()->id, // Crea un proyecto si no existe
                'phase_id' => Phase::inRandomOrder()->first()->id ?? null, // Relación opcional con fase
                'title' => $this->faker->sentence(3),
                'description' => $this->faker->paragraph(),
                'completed' => $this->faker->boolean(),
            ];
        }
    }


