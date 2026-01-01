<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'slug' => Str::slug($this->faker->unique()->sentence()),
            'body' => $this->faker->paragraph(),
        ];
    }
}
