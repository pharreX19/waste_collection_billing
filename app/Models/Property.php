<?php

namespace App\Models;

use App\Models\Person;
use App\Models\PropertyCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property extends Model
{
    /** @use HasFactory<\Database\Factories\PropertyFactory> */
    use HasFactory;
    use HasUlids;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'registration_no',
        'registration_date',
        'property_category_id',
        'address',
        'registration_code',
        'is_active'
    ];


    public function responsiblePersons()
    {
        return $this->belongsToMany(Person::class);
    }

    public function category()
    {
        return $this->belongsTo(PropertyCategory::class, 'property_category_id');
    }
}
