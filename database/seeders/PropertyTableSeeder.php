<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Person;
use App\Models\Property;
use App\Models\PersonProperty;
use Illuminate\Database\Seeder;
use Symfony\Component\Uid\Ulid;
use App\Models\PropertyCategory;

class PropertyTableSeeder extends Seeder
{
    public function run(): void
    {
        $this->cvsToArray('database/data/house_holds.csv');
    }

    function cvsToArray($filename)
    {


        $file_to_read = fopen($filename, 'r');
        $header = fgetcsv($file_to_read, 1000, ',');
        $data = [];

        while (!feof($file_to_read)) {
            $line = fgetcsv($file_to_read, 1000, ',');
            if ($line) {
                $responsible_person = $line[0];
                $responsible_person_array =  explode('،', $responsible_person);
                $responsible_person_name = $responsible_person_array[0];
                $responsible_person_address = '';

                if (count($responsible_person_array) > 1) {
                    $responsible_person_address = explode('/', $responsible_person_array[1])[0];
                }

                $person = Person::create([
                    'name' => $responsible_person_name,
                    'contact_no' => '',
                    'national_id' => '',
                    'address' => $responsible_person_address,
                    'island' => 'B.Eydhafushi'
                ]);

                $houseHoldCategory = PropertyCategory::where('name', 'like', 'Residential - Occupied')->value('id');

                Property::withoutEvents(function () use ($line, $houseHoldCategory, $person) {
                    $property =  Property::create([
                        'name' => $line[1],
                        'registration_no' => $line[2],
                        'property_category_id' => $houseHoldCategory,
                        'registration_date' => Carbon::now(),
                        'registration_code' => $line[2] . "_" . fake()->countryCode(),
                        'owner_id' => $person->id,
                    ]);

                    PersonProperty::create([
                        'id' => Ulid::generate(),
                        'property_id' => $property->id,
                        'responsible_person_id' => $person->id
                    ]);
                });
            }
        }
    }
}
