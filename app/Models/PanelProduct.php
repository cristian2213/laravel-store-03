<?php

namespace App\Models;

use App\Models\Product;

// heredando los metodos del producto para el modelo del panel de administracion
class PanelProduct extends Product
{
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        //static::addGlobalScope(new AvailableScope);
    }

    public function getForeignKey()
    {
        return (new Product)->getForeignKey();
    }

    public function getMorphClass()
    {
        return (new Product)->getMorphClass();
    }
}
