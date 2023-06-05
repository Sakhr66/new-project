// Review.php (Model)
class Review extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

// Product.php (Model)
class Product extends Model
{
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}

// UserController.php (Controller)
public function submitReview(Request $request, $productId)
{
    // Validate form inputs
    $validatedData = $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'required|string|max:255',
    ]);
    
    $review = new Review();
    $review->user_id = auth()->user()->id;
    $review->product_id = $productId;
    $review->rating = $validatedData['rating'];
    $review->comment = $validatedData['comment'];
    $review->save();

    return redirect()->route('product.details', $productId)->with('success', 'Review submitted successfully.');
}

// ProductController.php (Controller)
public function showDetails($productId)
{
    $product = Product::find($productId);
    $reviews = $product->reviews;

    return view('product_details', ['product' => $product, 'reviews' => $reviews]);
}

// product_details.blade.php (View)
<h1>{{ $product->name }}</h1>
<p>{{ $product->description }}</p>

<h2>Reviews</h2>
@if
 ($reviews->count() > 0)
    <ul>
        
@foreach
 ($reviews as $review)
            <li>
                <p>Rating: {{ $review->rating }}</p>
                <p>{{ $review->comment }}</p>
                <p>By: {{ $review->user->name }}</p>
            </li>
        
@endforeach

    </ul>
@else
    <
