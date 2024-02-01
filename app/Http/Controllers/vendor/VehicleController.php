<?php

namespace App\Http\Controllers\vendor;

use App\Http\Controllers\Controller;
use App\Models\vehicle;
use App\Models\vendorInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    public function AddVehicle(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id' => 'required'
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ],430);
        }
        else{
            $vendor = vendorInfo::where('id',$request->id)->first();
            if(!$vendor)
            {
                return response()->json([
                        'status' => false,
                        'message' => 'record not found'
                ],404);
            }
            else{
                $vehicle = new vehicle;
                $vehicle->user_id = $vendor->user_id;
                $vehicle->name = $request->name;
                $vehicle->model = $request->model;
                $vehicle->year = $request->year;
                $vehicle->category = $request->category;
                $vehicle->license_plate_no = $request->license_plate_no;
                $vehicle->description = $request->description;
                if($vehicle->save())
                {
                    return response()->json([
                        'status' => true,
                        'message' => 'vehicle record added successfully'
                    ],200);
                }
                else{
                    return response()->json([
                        'status' => false,
                        'message' => 'something went wrong record not save'
                    ],430);
                }

            }

        }
    }
}
