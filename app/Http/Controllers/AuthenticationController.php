<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use PharIo\Manifest\Email;
use Illuminate\Support\Facades\Validator;
use Auth;

class AuthenticationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try{
            $validateUser = Validator::make($request->all(), [
                'name'=>['required', 'string'],
                'phone_number'=> ['required','unique:users'],
                'password'=>['required', 'min:6'],
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status'=> false,
                    'message'=>'validation error',
                    'errors'=>$validateUser->errors()
                ], 401);
            }
            $user = User::create([
                'name'=>$request->name,
                'phone_number'=>$request->phone_number,
                'password'=>$request->password
            ]);
            
            return response()->json([
                'status'=> true,
                'message'=>'User created successfully',
                'token'=>$user->createToken("API TOKEN")->plainTextToken
            ], 200);

        }catch(\Throwable $th){
            return response()->json([
                'status'=> false,
                'message'=>$th->getMessage()
            ], 500);
        }
    }

   public function login (Request $request)
   {
        try{
            $validateUser = Validator::make($request->all(), [
                'phone_number'=> ['required', 'exists:users'],
                'password'=>['required', 'min:6'],
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status'=> false,
                    'message'=>'validation error',
                    'errors'=>$validateUser->errors()
                ], 401);
            }

            if (!Auth::attempt($request->only(['phone_number', 'password']))){
                return response()->json([
                    'status'=> false,
                    'message'=>'Email and password does not match with our record.'
                ], 401);
            }

            $user = User::where('phone_number', $request->phone_number)->first();
            
            return response()->json([
                'status'=> true,
                'message'=>'User logged in successfully',
                'token'=>$user->createToken("API TOKEN")->plainTextToken
            ], 200);

        }catch(\Throwable $th){
            return response()->json([
                'status'=> false,
                'message'=>$th->getMessage()
            ], 500);
        }
    }
}
