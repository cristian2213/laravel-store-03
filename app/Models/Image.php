<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['path'];


    // relacion 1:1 (una imagen pertenece a un usuario o producto)
    public function imageable()
    {

        return $this->morphTo();
    }
}
