<?php

namespace App\Http\Controllers\Panel;

use App\Models\PanelProduct;
use App\Scopes\AvailableScope;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{

    // middleware se esta haciendo a través del route service provider

    public function index()
    {

        //* Eliminando el Eager loading
        $products = PanelProduct::without('images')->get();

        return view('products.index')->with([
            'products' => $products,
        ]);
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(ProductRequest $request)
    {

        //* segunda form (debe existir el fillable) 
        $product = PanelProduct::create($request->validated());


        return redirect()->route('products.index')->withSuccess("The product with id {$product->id} was created");
    }

    public function show(PanelProduct $product)
    {
        return view('products.show')->with([
            'product' => $product,
        ]);
    }

    public function edit(PanelProduct $product)
    {
        return view('products.edit')->with(["product" => $product]);
    }

    public function update(ProductRequest $request, PanelProduct $product)
    {

        $product->update($request->validated());

        return redirect()->route('products.index')->withSuccess("The product with id {$product->id} was updated");
    }

    public function destroy(PanelProduct $product)
    {
        $product->delete();

        return redirect()->route('products.index')->withSuccess("The product with id {$product->id} was deleted");;
    }
}
