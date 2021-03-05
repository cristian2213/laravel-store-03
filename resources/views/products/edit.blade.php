@extends('layouts.app')

@section('content')
    <h1>Edit a product</h1>

    <form action="{{ route('products.update', $product->id) }}" method="POST">
        {{-- token --}}
        @csrf
        {{-- falseamiento de metodo --}}
        @method('PUT')

        <div class="form-row">
            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" id="title" value="{{ $product->title }}" required>
        </div>

        <div class="form-row">
            <label for="description">description</label>
            <input type="text" class="form-control" name="description" id="description"
                value="{{ $product->description }}" required>
        </div>

        <div class="form-row">
            <label for="price">Price</label>
            <input type="number" class="form-control" name="price" id="price" min="1.00" step="0.01"
                value="{{ $product->price }}" required>
        </div>

        <div class="form-row">
            <label for="stock">Stock</label>
            <input type="number" class="form-control" name="stock" id="stock" min="0" value="{{ $product->stock }}"
                required>
        </div>

        <div class="form-row">
            <label for="status">Status</label>
            <select name="status" id="status"  class="form-control" required>
                <option value="available" {{ $product->status === 'available' ? 'selected' : '' }}>Available</option>
                <option value="unavailable" {{ $product->status === 'unavailable' ? 'selected' : '' }}>Unavailable
                </option>
            </select>
        </div>

        <div class="form-row">
            <input type="submit" value="Edit product" class="btn btn-primary mt-3">
        </div>

    </form>

@endsection
