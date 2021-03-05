<?php

namespace App\Models;

use App\Models\Cart;
use App\Models\Order;
use App\Scopes\AvailableScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory; // permite enlazar el modelo con el factory

    protected $table = 'products';

    //* Eager Loading
    protected $with = [
        'images'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'price',
        'stock',
        'status'
    ];

    //* Aplicando Global scope

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new AvailableScope);
    }

    // ** Relaciones

    // relacion 1:n polimorfica (un producto tiene muchas imagenes)
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable'); // segundo prametro nombre de la relacion polomorfica
    }

    // relacion polimorfica de n:n product with card (muchas productos pueden pertenecer a muchos carritos)
    public function carts()
    {

        return $this->morphedByMany(Cart::class, 'productable')->withPivot('quantity');
    }

    // relacion polimorfica de n:n product with order (muchas productos pueden pertenecer a muchos ordenes)
    public function orders()
    {

        return $this->morphedByMany(Order::class, 'productable')->withPivot('quantity');
    }

    public function scopeAvailable($query)
    {
        $query->where('status', 'available');
    }

    //** Declaracion de Accessor
    public function getTotalAttribute($value)
    {
        // $this = accede al producto
        return $this->pivot->quantity * $this->price;
    }
}
