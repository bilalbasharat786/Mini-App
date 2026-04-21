<h1>Jamal Collection - Store</h1>
<div class="products">
    @foreach($products as $product)
        <div class="card">
            <h3>{{ $product->name }}</h3>
            <p>Price: ${{ $product->price }}</p>
        </div>
    @endforeach
</div>