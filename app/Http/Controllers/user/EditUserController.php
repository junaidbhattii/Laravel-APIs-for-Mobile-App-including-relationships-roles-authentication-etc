<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EditUserController extends Controller
{
    public function EditUser(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required'
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ],422);
        }
        else{
        $user = User::where('email', $request->email)->first();
        if(!$user)
        {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ],404);
        }
        else{
            $user->name = $request->input('name') ?? $user->name;
            $user->address = $request->input('address') ?? $user->address;
            $user->city = $request->input('city') ?? $user->city;
            $user->zip_code = $request->input('zip_code') ?? $user->zip_code;
            if($user->update())
            {
                return response()->json([
                    'status' => true,
                    'message' => "User Edit succesfully",
                    'record' => $this->ResponseData($user)
                ],200);
            }
            else{
                return response()->json([
                    'status' => false,
                    'message' => "User not edit something went wrong"
                ],422);
            }
        }
    }
    }
    public function ResponseData($user)
    {
        $json = [
            'id' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
            'address' => $user->address,
            'city' => $user->city,
            'zip_code' => $user->zip_code,
        ];
        return $json;
    }
}
