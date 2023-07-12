<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function PendingOrders()
    {
        $orders = Order::where('status', 'pending')->orderBy('id', 'DESC')->get();
        return view('backend.order.pending_orders', compact('orders'));
    }

    public function PendingOrdersDetails($order_id)
    {
        $order = Order::with('division', 'district', 'province', 'user')->where('id', $order_id)->first();
        $orderItem = OrderItem::with('product')->where('order_id', $order_id)->orderBy('id', 'DESC')->get();
        return view('backend.order.pending_orders_details', compact('order', 'orderItem'));
    }

    public function ConfirmedOrders()
    {
        $orders = Order::where('status', 'confirm')->orderBy('id', 'DESC')->get();
        return view('backend.order.confirmed_orders', compact('orders'));
    }

    public function ProcessingOrders()
    {
        $orders = Order::where('status', 'processing')->orderBy('id', 'DESC')->get();
        return view('backend.order.processing_orders', compact('orders'));
    }

    public function PickedOrders()
    {
        $orders = Order::where('status', 'picked')->orderBy('id', 'DESC')->get();
        return view('backend.order.picked_orders', compact('orders'));
    }

    public function ShippedOrders()
    {
        $orders = Order::where('status', 'shipped')->orderBy('id', 'DESC')->get();
        return view('backend.order.shipped_orders', compact('orders'));
    }

    public function DeliveredOrders()
    {
        $orders = Order::where('status', 'delivered')->orderBy('id', 'DESC')->get();
        return view('backend.order.delivered_orders', compact('orders'));
    }

    public function CancelOrders()
    {
        $orders = Order::where('status', 'cancel')->orderBy('id', 'DESC')->get();
        return view('backend.order.cancel_orders', compact('orders'));
    }

    public function PendingToConfirm($order_id)
    {
        Order::findOrFail($order_id)->update(['status' => 'confirm']);

        $notification = array(
            'message' => 'Order Confirm Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('pending-orders')->with($notification);
    }

    public function ConfirmToProcessing($order_id)
    {

        Order::findOrFail($order_id)->update(['status' => 'processing']);

        $notification = array(
            'message' => 'Order Processing Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('confirmed-orders')->with($notification);
    }


    public function ProcessingToPicked($order_id)
    {
        Order::findOrFail($order_id)->update(['status' => 'picked']);

        $notification = array(
            'message' => 'Order Picked Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('processing-orders')->with($notification);
    }


    public function PickedToShipped($order_id)
    {
        Order::findOrFail($order_id)->update(['status' => 'shipped']);

        $notification = array(
            'message' => 'Order Shipped Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('picked-orders')->with($notification);
    }


    public function ShippedToDelivered($order_id)
    {
        $product = OrderItem::where('order_id',$order_id)->get();
        foreach ($product as $item) {
            Product::where('id',$item->product_id)->update(['product_qty' => DB::raw('product_qty-'.$item->qty)]);
        }

        Order::findOrFail($order_id)->update(['status' => 'delivered']);
        $notification = array(
            'message' => 'Order Delivered Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('shipped-orders')->with($notification);
    }

    public function AdminInvoiceDownload($order_id)
    {
        $order = Order::with('division', 'district', 'province', 'user')->where('id', $order_id)->first();
        $orderItem = OrderItem::with('product')->where('order_id', $order_id)->orderBy('id', 'DESC')->get();

        $pdf = PDF::loadView('backend.order.order_invoice',compact('order','orderItem'))->setPaper('a4')->setOptions([
            'tempDir' => public_path(),
            'chroot' => public_path(),
        ]);
    return $pdf->download('invoice.pdf');
    }
}
