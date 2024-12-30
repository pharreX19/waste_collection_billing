<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Person;
use App\Models\Property;
use App\Models\PersonProperty;
use Illuminate\Database\Seeder;
use Symfony\Component\Uid\Ulid;
use App\Models\PropertyCategory;
use App\Models\ResponsiblePerson;
use Illuminate\Support\Facades\DB;
use App\Models\PropertyResponsiblePerson;

class BusinessPropertyTableSeeder extends Seeder
{
    public function run(): void
    {
        $this->cvsToArray('database/data/businesses.csv');
    }

    function cvsToArray($filename)
    {
        $file_to_read = fopen($filename, 'r');
        $header = fgetcsv($file_to_read, 1000, ',');
        $data = [];

        while (!feof($file_to_read)) {
            $line = fgetcsv($file_to_read, 1000, ',');
            if ($line) {
                $cleaned_value = str_replace(',', '', trim($line[1]));
                $fee = floatval($cleaned_value);


                $houseHoldCategory = PropertyCategory::where('service_fee', '=', $fee)
                    ->orWhere('service_fee', '<=', $fee)->value('id');

                info($line);
                info(floatval($line[1]));

                $registration_no = $line[3];
                $property_name = $line[2];
                $address_array = explode('،', $line[0]);

                $responsible_person_name = $address_array[0];

                $property = Property::create([
                    'name' => $property_name,
                    'registration_no' => $registration_no,
                    'property_category_id' => $houseHoldCategory,
                    'registration_date' => Carbon::now(),
                    'registration_code' => $line[2] . "_" . fake()->countryCode(),
                ]);

                $person = Person::create([
                    'name' => $responsible_person_name,
                    'contact_no' => '',
                    'national_id' => '',
                    'address' => $address_array[1] ?? '',
                    'island' => 'B.Eydhafushi'
                ]);

                PersonProperty::create([
                    'id' => Ulid::generate(),
                    'property_id' => $property->id,
                    'responsible_person_id' => $person->id
                ]);
            }
        }
    }
}
