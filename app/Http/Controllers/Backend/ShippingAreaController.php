<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShipDivision;
use App\Models\ShipDistrict;
use App\Models\ShipProvince;
use Carbon\Carbon;

class ShippingAreaController extends Controller
{
    public function DivisionView()
    {
        $divisions = ShipDivision::orderBy('id', 'DESC')->get();
        return view('backend.ship.division.view_division', compact('divisions'));
    }

    public function DivisionStore(Request $request)
    {
        $request->validate([
            'division_name' => 'required',
        ]);

        ShipDivision::insert([
            'division_name' => $request->division_name,
            'created_at' => Carbon::now(),
        ]);

        $notification = [
            'message' => 'Division Inserted Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }

    public function DivisionEdit($id)
    {
        $division = ShipDivision::findOrFail($id);
        return view('backend.ship.division.edit_division', compact('division'));
    }

    public function DivisionUpdate(Request $request, $id)
    {
        ShipDivision::findOrFail($id)->update([
            'division_name' => $request->division_name,
            'created_at' => Carbon::now(),

        ]);

        $notification = [
            'message' => 'Division Updated Successfully',
            'alert-type' => 'info'
        ];

        return redirect()->route('manage-division')->with($notification);
    }

    public function DivisionDelete($id)
    {
        ShipDivision::findOrFail($id)->delete();
        $notification = [
            'message' => 'Division Deleted Successfully',
            'alert-type' => 'info'
        ];

        return redirect()->back()->with($notification);
    }

    // Start Shipping District
    public function DistrictView()
    {
        $divisions = ShipDivision::orderBy('division_name', 'ASC')->get();
        $districts = ShipDistrict::with('division')->orderBy('id', 'DESC')->get();
        return view('backend.ship.district.view_district', compact('divisions', 'districts'));
    }

    public function DistrictStore(Request $request)
    {
        $request->validate([
            'division_id' => 'required',
            'district_name' => 'required',
        ]);

        ShipDistrict::insert([
            'division_id' => $request->division_id,
            'district_name' => $request->district_name,
            'created_at' => Carbon::now(),
        ]);

        $notification = [
            'message' => 'District Inserted Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }

    public function DistrictEdit($id)
    {
        $divisions = ShipDivision::orderBy('division_name', 'ASC')->get();
        $district = ShipDistrict::findOrFail($id);
        return view('backend.ship.district.edit_district', compact('divisions', 'district'));
    }

    public function DistrictUpdate(Request $request, $id)
    {
        ShipDistrict::findOrFail($id)->update([
            'division_id' => $request->division_id,
            'district_name' => $request->district_name,
            'created_at' => Carbon::now(),
        ]);

        $notification = [
            'message' => 'District Updated Successfully',
            'alert-type' => 'info'
        ];

        return redirect()->route('manage-district')->with($notification);
    }

    public function DistrictDelete($id)
    {
        ShipDistrict::findOrFail($id)->delete();
        $notification = [
            'message' => 'District Deleted Successfully',
            'alert-type' => 'info'
        ];

        return redirect()->back()->with($notification);
    }

    public function ProvinceView()
    {
        $division = ShipDivision::orderBy('division_name', 'ASC')->get();
        $district = ShipDistrict::orderBy('district_name', 'ASC')->get();
        $province = ShipProvince::with('division', 'district')->orderBy('id', 'DESC')->get();;
        return view('backend.ship.province.view_province', compact('division', 'district', 'province'));
    }

    public function ProvinceStore(Request $request)
    {

        $request->validate([
            'division_id' => 'required',
            'district_id' => 'required',
            'province_name' => 'required',

        ]);

        ShipProvince::insert([

            'division_id' => $request->division_id,
            'district_id' => $request->district_id,
            'province_name' => $request->province_name,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Province Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }


    public function ProvinceEdit($id)
    {
        $division = ShipDivision::orderBy('division_name', 'ASC')->get();
        $district = ShipDistrict::orderBy('district_name', 'ASC')->get();
        $province = ShipProvince::findOrFail($id);
        return view('backend.ship.province.edit_province', compact('division', 'district', 'province'));
    }

    public function ProvinceUpdate(Request $request,$id){

    	ShipProvince::findOrFail($id)->update([

		'division_id' => $request->division_id,
		'district_id' => $request->district_id,
		'province_name' => $request->province_name,
		'created_at' => Carbon::now(),

    	]);

	    $notification = array(
			'message' => 'Province Updated Successfully',
			'alert-type' => 'info'
		);

		return redirect()->route('manage-province')->with($notification);
    }

    public function ProvinceDelete($id)
    {
        ShipProvince::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Province Deleted Successfully',
            'alert-type' => 'info'
        );

        return redirect()->back()->with($notification);
    }
}
