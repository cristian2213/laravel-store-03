<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',

    ];

    /**
     * The attributes that should be hidden for arrays.
     * 
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     * 
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @deprecated Use the "casts" property
     *
     * @var array
     */
    protected $dates = ['admin_since'];

    // relacion 1:n User has many Orders (un usuario tiene muchas ordenes) 
    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    // relacion Has Many Through, Un usuario tiene muchos pagos a través de una orden
    public function payments()
    {

        return $this->hasManyThrough(Payment::class, Order::class, 'customer_id');
    }

    // relacion 1:1 polimorfica (un usuario tiene una imagen)
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function isAdmin()
    {
        return $this->admin_since != null && $this->admin_since->lessThanOrEqualTo(now());
    }

    public function getProfileImagesAttribute()
    {
        return $this->image ? "/images/{$this->image->path}" : "https://es.gravatar.com/avatar/404?d=mp";
    }
}
