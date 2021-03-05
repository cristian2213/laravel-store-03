<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Services\CartServices;
use Illuminate\Support\Facades\DB;

class OrderPaymentController extends Controller
{

    public $cartService;

    public function __construct(CartServices $cartService)
    {
        $this->cartService = $cartService;

        $this->middleware('auth');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function create(Order $order)
    {
        return view('payments.create')->with([
            'order' => $order
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Order $order)
    {
        return DB::transaction(function () use ($order, $request) {

            //PaymentService::handlePayment();

            $cart = $this->cartService->getFromCookie();
            // vaciar todos los productos del carrito
            $cart->products()->detach();

            // crea el pago para la orden
            $order->payment()->create([
                'amount' =>  $order->total,
                'payed_at' => now(),
            ]);

            // actualizar el status de la orden
            $order->status = 'payed';
            $order->save();

            return redirect()->route('main')->withSuccess("Thank! Your payment for \${$order->total} was successful.");
        }, 5); // intentos
    }
}
