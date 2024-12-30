<?php

namespace App\Models;

use App\Models\Payable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    use HasFactory;
    use HasUlids;
    use SoftDeletes;

    protected $fillable = [
        'payable_id',
        'amount',
        'state',
        'payment_date'
    ];

    protected static function booted()
    {
        // static::addGlobalScope('userPayment', function (Builder $query) {
        //     return $query->whereHas('payable', function ($q) {
        //         return $q->where('property_id', request()->propertyId);
        //     });
        // });
    }

    public function payable()
    {
        return $this->belongsTo(Payable::class);
    }
}
