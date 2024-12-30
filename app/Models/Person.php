<?php

namespace App\Models;

use App\Models\Property;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Person extends Model
{
    /** @use HasFactory<\Database\Factories\ResponsiblePersonFactory> */
    use HasFactory;
    use HasUlids;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'national_id',
        'contact_no',
        'address'
    ];


    public function properties()
    {
        return $this->belongsToMany(Property::class, 'person_properties');
    }
}
