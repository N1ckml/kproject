<?php

namespace Database\Factories;

use App\Models\Phase;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Phase>
 */
class PhaseFactory extends Factory
{
    /**
     * El nombre del modelo que esta factoría va a representar.
     *
     * @var string
     */
    protected $model = Phase::class;

    /**
     * Define el estado de la factoría.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            //
            'project_id' => Project::factory(), // Genera un proyecto también
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
        ];
    }
}
