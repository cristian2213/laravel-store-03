<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\CartServices;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

// gestion de las ordenes
class OrderController extends Controller
{
    public $cartService;

    //* Inyeccion de dependencia
    public function __construct(CartServices $cartService)
    {
        $this->cartService = $cartService;

        $this->middleware('auth');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cart = $this->cartService->getFromCookie();

        // check if the cart exists or check if there are products
        if (!isset($cart) || $cart->products->isEmpty()) {
            return redirect()
                ->back()
                ->withErrors('Your cart is empty!');
        }

        return view('orders.create')->with([
            'cart' => $cart,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //* Creacion de transaction
        return DB::transaction(function () use ($request) {
            // usuario autenticado
            $user = $request->user();

            $order = $user->orders()->create([
                'status' => 'pending',
            ]);


            $cart = $this->cartService->getFromCookie();

            $cart = $cart->products;

            $cartProductsWithQuantity =
                $cart->mapWithKeys(function ($product) {

                    $element[$product->id] = ['quantity' => $product->pivot->quantity];

                    $quantity = $product->pivot->quantity;

                    if ($product->stock < $quantity) {
                        throw ValidationException::withMessages([
                            'product' => "There is not enough stock for the quantity you required of {$product->title}"
                        ]);
                    }

                    $product->decrement('stock', $quantity);

                    return $element;
                });

            $order->products()->attach($cartProductsWithQuantity->toArray());


            return redirect()->route('orders.payments.create', ['order' => $order]);
        }, 5); // si falla se repetira la transaccion 5 veces
    }
}
