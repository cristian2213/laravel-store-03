@extends('layouts.app')

@section('content')
    <h1>Order Details</h1>

    <h4 class="text-center"><strong>Grand Total: </strong>{{ $cart->total }}</h4>

    <div class="text-center mb-3">

        <form action="{{ route('orders.store') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success mb-3">Confirm order</button>
        </form>

    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($cart->products as $product)
                    <tr>
                        <td class="d-flex">
                            <img src="{{ asset($product->images->first()->path) }}" alt="{{ $product->title }}"
                                height="100" class="mr-2">
                            {{ $product->title }}
                        </td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->pivot->quantity }}</td>

                        <td>
                            <strong>
                                {{-- retorna el precio de cada producto en su totalidad --}}
                                ${{ $product->total }}
                            </strong>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
