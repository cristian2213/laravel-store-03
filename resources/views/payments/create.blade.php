@extends('layouts.app')

@section('content')
    <h1>Payments Details</h1>

    <h4 class="text-center"><strong>Grand Total: </strong>{{ $order->total }}</h4>

    <div class="text-center mb-3">

        <form action="{{ route('orders.payments.store', ['order' => $order->id]) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success mb-3">Pay</button>
        </form>

    </div>

@endsection
