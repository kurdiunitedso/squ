<?php

namespace Database\Factories;

use App\Models\ProgramPageQuestion;
use App\Services\Constants\GetConstantService;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProgramPageQuestionFactory extends Factory
{
    protected $model = ProgramPageQuestion::class;

    public function definition()
    {
        $fieldTypes = GetConstantService::get_question_type_list();
        $fieldType = $fieldTypes->random();

        $options = [];
        if (in_array($fieldType->constant_name, ['dropdown', 'checkbox'])) {
            $options = [
                'en' => $this->faker->words(rand(3, 6)),
                'ar' => array_map(function ($i) {
                    return 'خيار ' . $i;
                }, range(1, rand(3, 6)))
            ];
        }

        return [
            'field_type_id' => $fieldType->id,
            'question' => [
                'en' => $this->faker->sentence() . '?',
                'ar' => 'سؤال ' . $this->faker->numberBetween(1, 100) . '؟'
            ],
            'options' => $options,
            'score' => $this->faker->numberBetween(1, 10),
            'required' => $this->faker->boolean(70),
            'order' => $this->faker->numberBetween(1, 10)
        ];
    }
}
