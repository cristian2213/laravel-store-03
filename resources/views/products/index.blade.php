@extends('layouts.app')

@section('content')
    <h1>List of products</h1>
    {{-- Lo mismo que if con el else --}}
    {{-- @empty($record)
    
    @else

    @endempty --}}

    <a href="{{ route('products.create') }}" class="btn btn-success mb-3">Create</a>

    @if (count($products) > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Titulo</th>
                        <th>Descripcion</th>
                        <th>price</th>
                        <th>stock</th>
                        <th>status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->title }}</td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>{{ $product->status }}</td>
                            <td class="d-flex">
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-link">Show</a>
                                {{-- <a href="{{ route('products.show', $product->title) }}" class="btn btn-link">Show</a> --}}

                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-link">Edit</a>

                                <form action="{{ route('products.destroy', ['product' => $product->id]) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('delete')

                                    <button type="submit" class="btn btn-link">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>There are not products</p>
    @endif

@endsection
