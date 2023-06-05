use App\Http\Controllers\ProductController;

Route::get('/products', [ProductController::class, 'index'])->name('products');

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', ['products' => $products]);
    }
}

@extends
('http://layouts.app')

@section
('content')
    <h1>Product Listing</h1>
    <div class="product-list">
        
@foreach
 ($products as $product)
            <div class="product">
                <h2>{{ $product->name }}</h2>
                <p>{{ $product->description }}</p>
                <p>Price: ${{ $product->price }}</p>
                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    
@csrf

                    <button type="submit">Add to Cart</button>
                </form>
            </div>
        
@endforeach

    </div>
@endsection
