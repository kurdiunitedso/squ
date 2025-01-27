<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Seeder;

class CountryCitySeeder extends Seeder
{
    protected array $locationData = [
        [
            'country' => [
                'code' => 'OM',
                'icon' => 'media/flags/oman.svg',
                'name' => [
                    'en' => 'Oman',
                    'ar' => 'عُمان'
                ]
            ],
            'cities' => [
                ['en' => 'Muscat', 'ar' => 'مسقط'],
                ['en' => 'Salalah', 'ar' => 'صلالة'],
                ['en' => 'Sohar', 'ar' => 'صحار'],
                ['en' => 'Sur', 'ar' => 'صور'],
                ['en' => 'Nizwa', 'ar' => 'نزوى'],
                ['en' => 'Ibri', 'ar' => 'عبري'],
                ['en' => 'Ibra', 'ar' => 'إبراء'],
                ['en' => 'Bahla', 'ar' => 'بهلاء'],
                ['en' => 'Rustaq', 'ar' => 'الرستاق'],
                ['en' => 'Al-Khabourah', 'ar' => 'الخابورة']
            ]
        ]
    ];

    public function run(): void
    {
        foreach ($this->locationData as $location) {
            $country = $this->createCountry($location['country']);
            $this->createCities($country, $location['cities']);
        }

        $this->command->info('Locations seeded successfully!');
    }

    protected function createCountry(array $countryData): Country
    {
        return Country::updateOrCreate(
            ['code' => $countryData['code']],
            [
                'name' => $countryData['name'],
                'icon' => $countryData['icon']
            ]
        );
    }

    protected function createCities(Country $country, array $cities): void
    {
        foreach ($cities as $cityData) {
            City::updateOrCreate(
                [
                    'country_id' => $country->id,
                    'name' => $cityData
                ]
            );
        }
    }
}
