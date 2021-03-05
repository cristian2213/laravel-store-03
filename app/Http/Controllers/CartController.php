<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Services\CartServices;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public $cartService;

    //* Inyeccion de dependencias
    public function __construct(CartServices $cartService)
    {
        $this->cartService = $cartService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // obtiene la cookie o retorna null
        $cart = $this->cartService->getFromCookie();

        return view('carts.index')->with([
            'cart' => $cart
        ]);
    }
}
