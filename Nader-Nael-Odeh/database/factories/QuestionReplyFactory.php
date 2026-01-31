<?php

namespace Database\Factories;

use App\Models\QuestionReply;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionReplyFactory extends Factory
{
    protected $model = QuestionReply::class;

    public function definition(): array
    {
        return [
            'body' => $this->faker->paragraph(),
        ];
    }
}
