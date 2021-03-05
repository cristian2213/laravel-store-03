<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'customer_id'
    ];

    // relacion 1:1 order has a payment (orden tiene un pago)
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // relacion 1:1 order belongs to an user (una orden pertenece a un usuario)
    public function user()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    // relacion polimorfica de n:n Order to product (muchas Ordenes pueden tener muchos productos)
    public function products()
    {
        return $this->morphToMany(Product::class, 'productable')->withPivot('quantity');
    }

    //** Declaracion de Accessor (propiedad computada)
    public function getTotalAttribute()
    {

        return $this->products->pluck('total')->sum();
    }
}
