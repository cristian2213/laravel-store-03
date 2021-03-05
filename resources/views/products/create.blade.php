@extends('layouts.app')

@section('content')



    <h1>Create a product</h1>

    <form action="{{ route('products.store') }}" method="POST" novalidate>
        {{-- token --}}
        @csrf

        <div class="form-row">
            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" required>
        </div>

        <div class="form-row">
            <label for="description">description</label>
            <input type="text" class="form-control" name="description" id="description" value="{{ old('description') }}"
                required>
        </div>

        <div class="form-row">
            <label for="price">Price</label>
            <input type="number" class="form-control" name="price" id="price" min="1.00" step="0.01"
                value="{{ old('price') }}" required>
        </div>

        <div class="form-row">
            <label for="stock">Stock</label>
            <input type="number" class="form-control" name="stock" id="stock" min="0" value="{{ old('stock') }}" required>
        </div>

        <div class="form-row">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="" selected>Select...</option>
                <option {{ old('status') === 'available' ? 'selected' : '' }} value="available">Available</option>
                <option {{ old('status') === 'unavailable' ? 'selected' : '' }} value="unavailable">Unavailable</option>
            </select>
        </div>

        <div class="form-row">
            <input type="submit" value="Send" class="btn btn-primary mt-3">
        </div>

    </form>

@endsection
