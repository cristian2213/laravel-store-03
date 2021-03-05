<?php

namespace App\Services;

use App\Models\Cart;
use Illuminate\Support\Facades\Cookie;

class CartServices
{

  protected $cookieName;
  protected $cookieExpiration;

  public function __construct()
  {
    // ambos datos vienen del archivo de configuracion
    $this->cookieName = config('cart.cookie.name');
    $this->cookieExpiration = config('cart.cookie.expiration');
  }

  //* Obtiene el carrito
  public function getFromCookie()
  {
    // obtener la cookie con el identificador
    $cartId = Cookie::get($this->cookieName);

    // se busca el carrito
    $cart = Cart::find($cartId);

    return $cart;
  }

  //* Retorna Carrito existente o crea Uno
  public function getFromCookieOrCreate()
  {
    $cart = $this->getFromCookie();


    return $cart ?? Cart::create();
  }

  //* Crea la Cookie y Se usa para prolongar el tiempo de la Cookie cuando se elimina
  public function makeCookie(Cart $cart)
  {
    // crear cookie
    return Cookie::make($this->cookieName, $cart->id, $this->cookieExpiration)
  }

  //* Cuenta el numero de productos existentes en el carrito
  public function countProduct()
  {
    $cart = $this->getFromCookie();

    if ($cart != null) {
      //* collections
      return $cart->products->pluck('pivot.quantity')->sum();
    }

    return 0;
  }
}
