<?php

namespace Database\Seeders;

use App\Models\Program;
use App\Models\ProgramPage;
use App\Models\ProgramPageQuestion;
use App\Services\Constants\GetConstantService;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProgramSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Get constants for relationships
        $targetApplicants = GetConstantService::get_program_target_applicants_list();
        $categories = GetConstantService::get_program_category_list();
        $eligibilities = GetConstantService::get_program_eligibility_type_list();
        $facilities = GetConstantService::get_program_facility_list();

        // Create 10 programs
        for ($i = 0; $i < 3; $i++) {
            $program = Program::create([
                'name' => [
                    'en' => $faker->company(),
                    'ar' => 'برنامج ' . $faker->numberBetween(1, 100)
                ],
                'description' => [
                    'en' => $faker->paragraph(3),
                    'ar' => 'وصف البرنامج ' . $faker->numberBetween(1, 100)
                ],
                'how_to_apply' => [
                    'en' => $faker->paragraph(),
                    'ar' => 'كيفية التقديم ' . $faker->numberBetween(1, 100)
                ],
                'deadline' => $faker->dateTimeBetween('+1 month', '+6 months'),
                'target_applicant_id' => $targetApplicants->random()->id,
                'category_id' => $categories->random()->id,
                'fund' => $faker->randomFloat(2, 1000, 100000),
            ]);

            // Sync relationships
            $program->syncEligibilities($eligibilities->random(rand(2, 4))->pluck('id')->toArray());
            $program->syncFacilities($facilities->random(rand(2, 4))->pluck('id')->toArray());

            // Create important dates
            for ($j = 0; $j < rand(2, 4); $j++) {
                $program->important_dates()->create([
                    'title' => [
                        'en' => $faker->sentence(),
                        'ar' => 'تاريخ مهم ' . $faker->numberBetween(1, 100)
                    ],
                    'date' => $faker->dateTimeBetween('now', '+1 year')
                ]);
            }

            // Create 3-5 pages for each program

            $numPages = rand(3, 5);
            for ($p = 0; $p < $numPages; $p++) {
                $page = ProgramPage::factory()->create([
                    'program_id' => $program->id,
                    'order' => $p + 1
                ]);

                $numQuestions = rand(3, 7);
                for ($q = 0; $q < $numQuestions; $q++) {
                    ProgramPageQuestion::factory()->create([
                        'program_id' => $program->id,
                        'program_page_id' => $page->id,
                        'order' => $q + 1
                    ]);
                }
            }
        }
    }
}
