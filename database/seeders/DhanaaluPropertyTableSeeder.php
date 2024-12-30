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

class DhanaaluPropertyTableSeeder extends Seeder
{
    public function run(): void
    {
        $this->cvsToArray('database/data/dhanaalu.csv');
    }

    function cvsToArray($filename)
    {


        $file_to_read = fopen($filename, 'r');
        $header = fgetcsv($file_to_read, 1000, ',');
        $data = [];

        while (!feof($file_to_read)) {
            $line = fgetcsv($file_to_read, 1000, ',');
            if ($line) {

                $houseHoldCategory = PropertyCategory::where('name', 'like', 'Residential - Occupied')->value('id');

                $property = Property::create([
                    'name' => $line[1],
                    'registration_no' => $line[2],
                    'property_category_id' => $houseHoldCategory,
                    'registration_date' => Carbon::now(),
                    'registration_code' => $line[2] . "_" . fake()->countryCode(),
                ]);

                $responsible_person_array = explode('/', $line[0]);


                foreach ($responsible_person_array as $person) {
                    $person = Person::create([
                        'name' => $person,
                        'contact_no' => '',
                        'national_id' => '',
                        'address' => '',
                        'island' => 'B.Eydhafushi',
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
}
