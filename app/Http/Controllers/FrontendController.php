<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Midtrans\Config;
use Midtrans\Snap;

class FrontendController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['galleries'])->latest()->get();

        return view('pages.frontend.index', compact('products'));
    }

    public function details(Request $request, $slug)
    {
        $product = Product::with(['galleries'])->where('slug', $slug)->firstOrFail();
        $recommendation = Product::with(['galleries'])->inRandomOrder()->limit('4')->get();

        return view('pages.frontend.details', compact('product', 'recommendation'));
    }

    public function cart(Request $request)
    {
        $carts = Cart::with(['product.galleries'])->where('users_id', Auth::user()->id)->get();

        return view('pages.frontend.cart', compact('carts'));
    }

    public function addCart(Request $request, $id)
    {

        Cart::create([
            'users_id' => Auth::user()->id,
            'products_id' => $id
        ]);

        return redirect('cart');
    }

    public function deleteCart(Request $request, $id)
    {
        $item = Cart::findOrFail($id);

        $item->delete();

        return redirect('cart');
    }

    public function checkout(Request $request)
    {
        // return $request->all();

        $data = $request->all();

        //Get Carts data
        $carts = Cart::with(['product'])->where('users_id', Auth::user()->id)->get();

        //Add to transaction data
        $data['users_id'] = Auth::user()->id;
        $data['total_price'] = $carts->sum('product.price');

        //Create transaction
        $transaction = Transaction::create($data);

        //Create transaction item
        foreach ($carts as $cart) {
            $items[] = TransactionItem::create([
                'transactions_id' => $transaction->id,
                'users_id' => $cart->users_id,
                'products_id' => $cart->products_id
            ]);
        }

        //If transaction success -> Delete cart after transaction
        Cart::where('users_id', Auth::user()->id)->delete();

        //Midtrans configuration
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        //Setup midtrans variable
        $midtrans = [
            'transaction_details' => [
                'order_id' => 'BILL-' . $transaction->id,
                'gross_amount' => (int) $transaction->total_price
            ],
            'customer_details' => [
                'first_name' => $transaction->name,
                'email' => $transaction->email,
            ],
            'enabled_payment' => [
                'gopay', 'bank_transfer'
            ],
            'vtweb' => []
        ];

        //Payment process
        try {
            //Get Snap payment page URL
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;

            // Save payment_url to Transaction Model
            $transaction->payment_url = $paymentUrl;
            $transaction->save();

            //Redirect to Snap Payment Page
            return redirect($paymentUrl);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function success(Request $request)
    {
        return view('pages.frontend.success');
    }
}
