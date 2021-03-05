<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount',
        'payed_at',
        'order_id'
    ];


    /**
     * The attributes that should be mutated to dates.
     *
     * @deprecated Use the "casts" property
     *
     * @var array
     */
    protected $dates = ['payed_at'];

    // relacion 1:1 payment belongs to an order (un pago pertenece a una orden)
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
