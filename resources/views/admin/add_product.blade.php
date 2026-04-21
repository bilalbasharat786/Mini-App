<form action="{{ route('product.store') }}" method="POST">
    @csrf
    <input type="text" name="name" placeholder="Product Name" required>
    <textarea name="description" placeholder="Description"></textarea>
    <input type="number" name="price" placeholder="Price">
    <input type="number" name="stock" placeholder="Stock">
    <button type="submit">Add Product</button>
</form>