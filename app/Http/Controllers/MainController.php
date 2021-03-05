<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function index()
    {
        // habilitando todos los log de las consultas en la db para examinar que tipo de consultas se hacen

        DB::connection()->enableQueryLog();

        //* Eager Loading

        $products = Product::with('images')->get();

        return view('welcome')->with([
            'products' => $products,
        ]);
    }
}
