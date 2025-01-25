<?php

namespace App\Models;

use App\Models\Payment;
use App\Models\Property;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payable extends Model
{
    /** @use HasFactory<\Database\Factories\PayableFactory> */
    use HasFactory;
    use HasUlids;
    use SoftDeletes;

    protected $fillable = [
        'property_id',
        'reference_no',
        'billed_period',
        'due_date',
        'amount',
        'discount',
        'fine',
        'grand_total',
        'state'
    ];

    protected static function booted()
    {
        // static::addGlobalScope('userPayable', function (Builder $query) {
        //     return $query->where('property_id', request()->propertyId);
        // });
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
