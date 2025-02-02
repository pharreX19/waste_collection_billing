<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyCategory extends Model
{
    /** @use HasFactory<\Database\Factories\PropertyCategoryFactory> */
    use HasFactory;
    use SoftDeletes;
    use HasUlids;

    protected $fillable = [
        'name',
        'description',
        'service_fee',
        'is_government'
    ];
}
