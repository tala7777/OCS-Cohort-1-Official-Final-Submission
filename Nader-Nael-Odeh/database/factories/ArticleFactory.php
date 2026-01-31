<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(5);
        return [
            'title' => $title,
            'image_path' => null,
            'slug' => Str::slug($title) . '-' . $this->faker->unique()->numberBetween(1000, 9999),
            'content' => $this->faker->paragraphs(5, true),
            'status' => $this->faker->randomElement(['draft', 'published']),
            'published_at' => $this->faker->optional(0.6)->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
