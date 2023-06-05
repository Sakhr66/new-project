// OrderController.php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function showCart()
    {
        $cart = session()->get('cart');

        return view('cart', ['cart' => $cart]);
    }

    public function addToCart(Request $request, $productId)
    {
        $product = Product::find($productId);

        return redirect()->route('cart')->with('success', 'Product added to cart.');
    }

    public function checkout(Request $request)
    {

        $order = new Order();
        $order->user_id = auth()->user()->id; // Assuming authenticated user
        // Set other order details
        $order->save();

        session()->forget('cart');

        return redirect()->route('order.confirmation')->with('success', 'Order placed successfully.');
    }

    public function confirmation()
    {
        return view('order_confirmation');
    }
}
