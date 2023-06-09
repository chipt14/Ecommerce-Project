<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ShipDistrict;
use App\Models\ShipProvince;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function DistrictGetAjax($division_id)
    {
        $ship = ShipDistrict::where('division_id', $division_id)
                            ->orderBy('district_name', 'ASC')
                            ->get();
        return json_encode($ship);
    }

    public function ProvinceGetAjax($district_id){

    	$ship = ShipProvince::where('district_id',$district_id)
                            ->orderBy('province_name','ASC')
                            ->get();
    	return json_encode($ship);
    }

    public function CheckoutStore(Request $request)
    {
        // dd($request->all());
        $data = array();
        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_phone'] = $request->shipping_phone;
        $data['post_code'] = $request->post_code;
        $data['division_id'] = $request->division_id;
        $data['district_id'] = $request->district_id;
        $data['province_id'] = $request->province_id;
        $data['notes'] = $request->notes;

        $cartTotal = Cart::total();

        if ($request->payment_method == 'stripe') {
            return view('frontend.payment.stripe', compact('data', 'cartTotal'));
        } elseif ($request->payment_method == 'card') {
            return 'card';
        } else {
            return view('frontend.payment.cash', compact('data', 'cartTotal'));
        }
    }
}
