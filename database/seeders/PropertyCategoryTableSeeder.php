<?php

namespace Database\Seeders;

use App\Models\PropertyCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropertyCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'ކެފޭ އަދި ރެސްޓޯރެންޓް', //'Cafes & Restaurants',
                'description' => 'މި ކެޓަގަރީގައި ހިމެނެނީ ކާބޯ ތަކެތި ތައްޔާރުކޮށް ޚިދުމަތް ދޭ ކެފޭ ރެސްޓޯރެންޓް ފަދަ ތަންތަނެވެ',
                'service_fee' => 500.0,
                'is_government' => 0,
            ],
            [
                'name' => 'މަތީފަންތީގެ ވިޔަފާރި', //'Large-Sized Business',
                'description' => 'މި ކެޓަގަރީގައި ހިމެނެނީ ބޮޑެތި ވިޔަފާރީގެ ޚިދުމަތް ދޭ ތަންތަނެވެ',
                'service_fee' => 1000.0,
                'is_government' => 0,
            ],
            [
                'name' => 'މެދުފަންތީގެ ވިޔަފާރި', //'Medium-Sized Business',
                'description' => 'މި ކެޓަގަރީގައި ހިމެނެނީ މެދު ފަންތީގެ ވިޔަފާރީގެ ޚިދުމަތް ދޭ ތަންތަނެވެ',
                'service_fee' => 500.0,
                'is_government' => 0,
            ],
            [
                'name' => 'ކުދި ވިޔަފާރި', //'Small-Sized Business',
                'description' => 'މި ކެޓަގަރީގައި ހިމެނެނީ ކުދި ވިޔަފާރީގެ ޚިދުމަތް ދޭ ތަންތަނެވެ',
                'service_fee' => 150.0,
                'is_government' => 0,
            ],
            [
                'name' => 'ސަރުކާރު ހިއްސާވާ ކުންފުނި', //'State-Owned Enterprises (SOE)',
                'description' => 'މި ކެޓަގަރީގައި ހިމެނެނީ ސަރުކާރު ހިއްސާވާ ކުންފުނި ތަކެވެ',
                'service_fee' => 1000.0,
                'is_government' => 1,
            ],
            [
                'name' => 'ހޮސްޕިޓަލް އަދި ސްކޫލް', //'Schools & Hospitals',
                'description' => 'މި ކެޓަގަރީގައި ހިމެނެނީ ބޭސް ފަރުވާ އަދި ތަޢުލީމީ ޚިދުމަތް ދޭ ތަންތަނެވެ',
                'service_fee' => 1000.0,
                'is_government' => 1,
            ],
            [
                'name' => 'ސަރުކާރު އޮފީސް', //'Government Offices',
                'description' => 'މި ކެޓަގަރީގައި ހިމެނެނީ ސަރުކާރު އޮފީސް ތަކެވެ',
                'service_fee' => 500.0,
                'is_government' => 1,
            ],
            [
                'name' => 'މީހުން ދިރިނޫޅޭ ގޯތި', //'Residential - Unoccupied',
                'description' => 'މި ކެޓަގަރީގައި ހިމެނެނީ މިވަގުތު މީހުން ދިރިނޫޅޭ ގޯތި ފަދަ ތަންތަނެވެ',
                'service_fee' => 75.0,
                'is_government' => 0,
            ],
            [
                'name' => 'މީހުން ދިރިއުޅޭ ގޯތި', //'Residential - Occupied',
                'description' => 'މި ކެޓަގަރީގައި ހިމެނެނީ މިވަގުތު މީހުން ދިރިއުޅެމުން ގެންދާ ގޯތި ފަދަ ތަންތަނެވެ',
                'service_fee' => 100.0,
                'is_government' => 0,
            ],
        ];


        foreach ($categories as $category) {
            PropertyCategory::create($category);
        }
    }
}
