<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthenticationController extends Controller
{
    public function Sign_Up(Request $request)
    {
        $validator = validator::make(
            $request->all(),
            [
                'name' => 'required | regex:/^[\pL\s\-]+$/u',
                'email' => 'required | unique:users',
                'password' => 'required | min:6',
            ]
            );
            if($validator->fails())
            {
                return response()->json([
                    'status' => false,
                    'message' => 'wrong credentials',
                    'error' => $validator->errors()
                ], 422);
            }
            else{
                $user = new User;
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->roles = ["ROLE_USER"];
                // $rolesArray = $user->roles;
                if(!$user->save())
                {
                    return response()->json([
                        'status' => false,
                        'message' => "something went wrong, user not save",
                    ],422);
                }
                else{
                    return response()->json([
                        'status' => true,
                        'message' => "user signup successfully",
                        'record' => $this->ResponseData($user),
                        
                    ],200);
                }
            }
    }
    public function ResponseData($user)
    {
        $json = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->roles,
            // 'serviceAreas' => $user->vendor_service_areas
        ];
        return $json;
    }

    public function Login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required',
            'password' => 'required'
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
            if (Auth::attempt($request->only('email', 'password'))) {
                $user = Auth::user();
                $userIP = $request->ip();
                return response()->json([
                    'status' => true,
                    'massage' => 'Login successfuly',
                    'user' => $this->ResponseData($user),
                    'userIP' => $userIP,
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid Credentials',
                ], 401);
            }
        }
    }
    public function ChangePassword(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required',
            'current_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required'
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()
            ],422);
        }
        else{
            $user = User::where('email',$request->email)->first();
            if($user)
            {
                if(!Hash::check($request->current_password , $user->password))
                {
                    return response()->json([
                        'status' => false,
                        'message' => 'current password not match '
                    ],422);
                }
                else{
                    if($request->new_password === $request->confirm_password)
                    {
                        $user->password = Hash::make($request->new_password);
                        if($user->update())
                        {
                            return response()->json([
                                'status' => true,
                                'message' => 'password changed successfully'
                            ],200);
                        }
                        else{
                            return response()->json([
                                'status' => false,
                                'message' => 'password not changed something went wrong'
                            ],422);
                        }
                    }
                    else{
                        return response()->json([
                            'status' => false,
                            'message' => 'new password and confirm password not match'
                        ],422);
                    }
                }
            }
            else{
                return response()->json([
                    'status' => false,
                    'message' => 'user not found'
                ],422);
            }
        }
    }
    
}
