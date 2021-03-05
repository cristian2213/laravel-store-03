<div class="col-3">
    <div class="card">
        {{-- se hacede a la carpeta publica y luego a la ruta "img/users/2.jpg" --}}

        <div id="carousel{{ $product->id }}" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                @foreach ($product->images as $image)
                    {{-- loop variable que se encuentra en el ciclo --}}
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <img src="{{ asset($image->path) }}" class="d-block w-100" height="300">
                    </div>
                @endforeach
            </div>

            @if (count($product->images) >= 1)
                <a class="carousel-control-prev" href="#carousel{{ $product->id }}" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carousel{{ $product->id }}" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            @endif
        </div>

        <div class="card-body">
            <h4 class="text-right"><strong>${{ $product->price }}</strong></h4>
            <h5 class="card-title">{{ $product->title }}</h5>
            <p class="card-text">{{ $product->description }}</p>
            <p class="card-text"><strong>{{ $product->stock }}</strong></p>

            @isset($cart)
                <p class="card-text">{{ $product->pivot->quantity }} in your cart
                    <strong>({{ $product->total }})</strong>
                </p>

                <form action="{{ route('products.carts.destroy', ['cart' => $cart->id, 'product' => $product->id]) }}"
                    method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">Delete From cart</button>
                </form>
            @else
                <form action="{{ route('products.carts.store', ['product' => $product->id]) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">Add to cart</button>
                </form>
            @endisset
        </div>
    </div>
</div>
