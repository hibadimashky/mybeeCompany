<?php

namespace Modules\General\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Modules\General\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $response = Http::timeout(300)->get('http://restcountries.com/v3.1/all');

        if ($response->successful()) {
            $countriesData = $response->json();

            foreach ($countriesData as $country) {
                $nameEn = $country['name']['common'] ?? null;
                $nameAr = $country['translations']['ara']['common'] ?? null;
                $isoCode = $country['cca2'] ?? null;
                $dialCode = isset($country['idd']['root']) && isset($country['idd']['suffixes'])
                    ? $country['idd']['root'] . $country['idd']['suffixes'][0]
                    : '+000';
                $currencyData = $country['currencies'] ?? [];
                $currencyNameEn = $currencySymbolEn = $currencyNameAr = $currencySymbolAr = null;

                if (!empty($currencyData)) {
                    $firstCurrency = array_values($currencyData)[0];
                    $currencyNameEn = $firstCurrency['name'] ?? null;
                    $currencySymbolEn = $firstCurrency['symbol'] ?? null;
                    $currencyNameAr = $firstCurrency['translations']['ara']['name'] ?? null;
                    $currencySymbolAr = $firstCurrency['translations']['ara']['symbol'] ?? null;
                }

                Country::updateOrCreate(
                    ['iso_code' => $isoCode],
                    [
                        'name_en' => $nameEn,
                        'name_ar' => $nameAr,
                        'dial_code' => $dialCode,
                        'currency_name_en' => $currencyNameEn,
                        'currency_symbol_en' => $currencySymbolEn,
                        'currency_name_ar' => $currencyNameAr,
                        'currency_symbol_ar' => $currencySymbolAr,
                    ]
                );
            }

            $this->command->info('Countries data imported successfully!');
        } else {
            $this->command->error('Failed to fetch countries data');
        }
    }
}