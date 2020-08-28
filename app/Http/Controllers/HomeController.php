<?php


namespace App\Http\Controllers;

use App\Product;
use App\ProductAddon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validate;
use App\Order;
use App\OrderDetail;

class HomeController extends Controller
{

    public function index() {
        $products = Product::with(['ProductAddon'])->get();

        return view('products')->with('products', $products);
    }

    public function addToCart(Request $request) {
        if($request->products) {
            $products = json_decode($request->products);
            $product_total = $grand_total = $sub_total = $quantity_total = 0;

            $order = new Order;
            $order->status = 'open';
            $order->created_at = Carbon::now();
            $order->updated_at = Carbon::now();
            $order->save();

            foreach($products as $product) {
                $prod = Product::find($product->id);
                $product_total += $prod->price * $product->quantity;

                $orderDetail = new OrderDetail();
                $orderDetail->order_id = $order->id;
                $orderDetail->product_id = $prod->id;
                $orderDetail->quantity = $product->quantity;
                $orderDetail->amount = $product_total;
                $orderDetail->created_at = Carbon::now();
                $orderDetail->updated_at = Carbon::now();
                $orderDetail->save();
            }

            if($request->addons) {
                $addons = json_decode($request->addons);
                foreach ($addons as $addon) {
                    $add = ProductAddon::find($addon->id);
                    $quantity_total += $add->price * $addon->quantity;

                    $orderDetail = new OrderDetail();
                    $orderDetail->order_id = $order->id;
                    $orderDetail->product_id = $add->product_id;
                    $orderDetail->addon_id = $add->id;
                    $orderDetail->quantity = $addon->quantity;
                    $orderDetail->amount = $quantity_total;
                    $orderDetail->created_at = Carbon::now();
                    $orderDetail->updated_at = Carbon::now();
                    $orderDetail->save();
                }
            }

            $sub_total = $product_total + $quantity_total;
            $tax = round($sub_total * 0.16);
            $grand_total = $sub_total + $tax;

            $order->sub_total = $sub_total;
            $order->tax = $tax;
            $order->grand_total = $grand_total;
            $order->save();

            $orderFetch = Order::with(['OrderDetail', 'OrderDetail.Product', 'OrderDetail.ProductAddon'])->where('id', $order->id)->first();
//            dd($orderFetch->OrderDetail->Product);
            return view('orderDetails')->with('orderDetails', $orderFetch);
        }
    }
}
