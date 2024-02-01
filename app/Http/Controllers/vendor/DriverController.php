<?php

namespace App\Http\Controllers\vendor;

use App\Http\Controllers\Controller;
use App\Models\driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\vendorInfo;
use Illuminate\Database\Console\Migrations\StatusCommand;
use Illuminate\Support\Facades\Hash;

class DriverController extends Controller
{
    public function AddDriver(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id' => 'required',
            // 'password' => 'required'
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ],422);
        }
        else{
            $vendor = vendorInfo::where('id', $request->id)->first();
            // dd($vendor);
            if(!$vendor)
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Vendor Not Found'
                ],404);
            }
            else{
                $user = new User;
                $user->name = $request->name;
                $user->last_name = $request->last_name;
                $user->email = $request->email;
                $user->phone_number = $request->phone_number;
                $user->password = Hash::make($request->password);
                $user->address = $request->address;
                $user->roles = ["ROLE_DRIVER"];
                if(!$user->save())
                {
                    return response()->json([
                        'status' => false,
                        'message' =>'Driver not save',
                    ],422);
                }
                else{
                    $driver = new driver;
                    $driver->SelfDriverProfileId = $user->id;
                    $driver->user_id = $vendor->user_id;
                    $driver->first_name = $user->name;
                    $driver->last_name = $user->last_name;
                    $driver->address = $user->address;
                    $driver->email = $user->email;
                    $driver->driving_licence_no = $request->driving_licence_no;
                    $driver->profile_picture = $request->profile_picture;
                    if(!$driver->save())
                    {
                        return response()->json([
                            'status' => false,
                            'message' => 'Driver Details not save'
                        ],422);
                    }
                    else{
                        return response()->json([
                            'status' => true,
                            'message' => 'Driver Successfully Add'
                        ],200);
                    }
                }
            }

        }
    }
}
