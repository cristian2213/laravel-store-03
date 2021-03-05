<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * withPivot: Set the columns on the pivot table to retrieve
     * @var array
     */

    public function products()
    {
        return $this->morphToMany(Product::class, 'productable')->withPivot('quantity');
    }


    public function getTotalAttribute()
    {
        // se trae el total del accessor que fue computado en el modelo de Product
        return $this->products->pluck('total')->sum();
    }
}
