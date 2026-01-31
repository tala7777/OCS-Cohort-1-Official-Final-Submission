<?php

namespace Database\Factories;

use App\Models\LawyerProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

class LawyerProfileFactory extends Factory
{
    protected $model = LawyerProfile::class;

    public function definition(): array
    {
        return [
            'bio' => $this->faker->paragraph(),
            'license_number' => strtoupper($this->faker->bothify('LIC-####-???')),
            'profile_photo_path' => null,
            'status' => 'accepted',
            'rejection_reason' => null,
        ];
    }
}
