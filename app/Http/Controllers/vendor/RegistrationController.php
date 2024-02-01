<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\vendorInfo;
use Faker\Provider\ar_EG\Address;
use Illuminate\Database\Console\Migrations\StatusCommand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegistrationController extends Controller
{
    //
    public function VendorRegistration(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required',
            'password' => 'required',
            'confirm_password' => 'required'
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status' => false,
                'message' => 'wrong credentials',
                'error' => $validator->errors()
            ],422);
        }
        else{
            $user = User::where('email',$request->email)->first();
            if($user)
            {
                $user->name = $request->input('name') ?? $user->name;
                $user->last_name = $request->input('last_name') ?? $user->last_name;
                $user->address = $request->input('address') ?? $user->address;
                $user->city = $request->input('city') ?? $user->city;
                $user->state = $request->input('state') ?? $user->state;
                $user->country = $request->input('country') ?? $user->country;
                $user->phone_number = $request->input('phone_number');

                $user->roles = ["ROLE_VENDOR"];
                if($user->update())
                {
                    if($this->vendorRegister($request)){
                        return response()->json([
                            'status' => true,
                            'message' => 'updated user as a vendor'
                        ],200);
                    }
                    else{
                        return response()->json([
                            'status' => false,
                            'message' => 'updated user as a vendor not possible'
                        ],200);
                    }

                }
                else{
                    return response()->json([
                        'status' => false,
                        'message' => 'user not update'
                    ],422);
                }

            }
            else{
                $user = new User;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);

                $user->roles = ["ROLE_VENDOR"];

                $user->name = $request->name;
                $user->last_name = $request->last_name;
                $user->address = $request->address;
                $user->city = $request->city;
                $user->state = $request->state;
                $user->country = $request->counrty;
                $user->phone_number = $request->phone_number;

                if($user->save())
                {
                    if($this->vendorRegister($request)){
                    return response()->json([
                        'status' => true,
                        'message' => "new vendor info added"
                    ],200);
                }
                else{
                    return response()->json([
                        'status' => false,
                        'message' => "new vendor info not added"
                    ],430);
                }
                }
                else{
                    return response()->json([
                        'status' => false,
                        'message' => 'Registration fails'
                    ],422);
                }
            }
        }
    }

    public function vendorRegister(Request $request)
    {
        $user = User::where('email',$request->email)->first();
                $vendorinfo = new vendorInfo;
                $vendorinfo->user_id = $user->id;
                $vendorinfo->usdot = $request->usdot;
                $vendorinfo->company_name = $request->company_name;
                $vendorinfo->mailing_address = $request->mailing_address;
                $vendorinfo->company_city = $request->company_city;
                $vendorinfo->company_state = $request->company_state;
                $vendorinfo->company_country = $request->company_country;
                $vendorinfo->company_zipcode = $request->company_zipcode;
                $vendorinfo->industry_association = $request->industry_association;
                $vendorinfo->amenities = $request->amenities;
                $vendorinfo->website_url= $request->website_url;
                $vendorinfo->paypal_email = $request->paypal_email;
                $vendorinfo->company_contect_number = $request->company_contect_number;
                $vendorinfo->no_vehicle = $request->no_vehicle;
                $vendorinfo->no_drivers = $request->no_drivers;
                $vendorinfo->MOTORCOACH = $request->MOTORCOACH;
                $vendorinfo->ENTERTAINER_MOTORCOACH = $request->ENTERTAINER_MOTORCOACH;
                $vendorinfo->SHUTTLE_BUS = $request->SHUTTLE_BUS;
                $vendorinfo->MINI_BUS = $request->MINI_BUS;
                $vendorinfo->PARTY_BUS = $request->PARTY_BUS;
                $vendorinfo->SCHOOL_BUS = $request->SCHOOL_BUS;
                $vendorinfo->LAIMOUSINES = $request->LAIMOUSINES;
                $vendorinfo->SUV = $request->SUV;
                $vendorinfo->SEDAN = $request->SEDAN;
                $vendorinfo->personal_vehicles = $request->personal_vehicles;
                $vendorinfo->TEXIES = $request->TEXIES;
                if($vendorinfo->save())
                {
                    return response()->json([
                        'status' => true,
                        'message' => 'vendor info save successfully'
                    ],200);
                }
                else{
                    return response()->json([
                        'status' => false,
                        'message' =>  'vendor not save something went wrong'
                    ],403);
                }
    }
}
