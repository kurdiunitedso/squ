<?php

namespace Database\Factories;

use App\Models\Program;
use App\Models\ProgramPage;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProgramPageFactory extends Factory
{
    protected $model = ProgramPage::class;

    public function definition()
    {
        return [
            'title' => [
                'en' => $this->faker->sentence(),
                'ar' => 'عنوان الصفحة ' . $this->faker->numberBetween(1, 100)
            ],
            'order' => $this->faker->numberBetween(1, 10),
            'structure' => json_encode([
                'sections' => [
                    [
                        'type' => 'text',
                        'content' => $this->faker->paragraphs(3, true)
                    ],
                    [
                        'type' => 'list',
                        'items' => $this->faker->words(5)
                    ]
                ]
            ])
        ];
    }
}
