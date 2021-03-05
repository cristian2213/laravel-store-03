@extends('layouts.app')

@section('content')
    <h1>Welcome</h1>
    @empty($products)
        <div class="alert alert-danger">
            No products yet!
        </div>
    @else
        <div class="row">
            {{-- @dump($products) --}}

            @foreach ($products as $product)
                {{-- blade component --}}
                @include('components.product-card')
            @endforeach


        </div>

        {{-- Aqui los productos tiene la relacion guardada --}}
        {{-- @dump($products) --}}

        {{-- Muestra todos las consultas que se hicieron --}}
        {{-- @dump(DB::getQueryLog()) --}}
    @endempty


@endsection
