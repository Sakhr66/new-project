use App\Http\Controllers\CartController;

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = session()->get('cart');

        return view('cart.index', ['cartItems' => $cartItems]);
    }

    public function add(Request $request, Product $product)
    {
        $quantity = $request->input('quantity', 1);

        $cartItems = session()->get('cart', []);
        $cartItems[$product->id] = $quantity;
        session()->put('cart', $cartItems);

        return redirect()->route('cart.index')->with('success', 'Product added to cart.');
    }

    public function update(Request $request, Product $product)
    {
        $quantity = $request->input('quantity', 1);

        $cartItems = session()->get('cart', []);
        if ($quantity > 0) {
            $cartItems[$product->id] = $quantity;
        } else {
            unset($cartItems[$product->id]);
        }
        session()->put('cart', $cartItems);

        return redirect()->route('cart.index')->with('success', 'Cart updated.');
    }

    public function remove(Product $product)
    {
        $cartItems = session()->get('cart', []);
        unset($cartItems[$product->id]);
        session()->put('cart', $cartItems);

        return redirect()->route('cart.index')->with('success', 'Product removed from cart.');
    }
}
