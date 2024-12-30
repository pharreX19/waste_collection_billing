<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PersonProperty extends Pivot
{
    use HasFactory;
    use SoftDeletes;
    use HasUlids;

    protected $table = 'person_properties';
}
