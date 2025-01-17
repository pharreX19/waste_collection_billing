<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Person;
use App\Models\PropertyCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
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


    protected $casts = [
        'registration_date' => 'date'
    ];


    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->registration_code = 'REG' . rand(1000, 9999) . time();
            $model->registration_date = Carbon::now();
        });
    }

    public function responsiblePersons()
    {
        return $this->belongsToMany(Person::class, 'person_properties', 'property_id', 'responsible_person_id');
    }

    public function category()
    {
        return $this->belongsTo(PropertyCategory::class, 'property_category_id');
    }
}
