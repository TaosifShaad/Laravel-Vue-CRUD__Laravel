<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required | email',
            'password' => 'required',
            'c_password' => 'required | same:password'
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $success['token'] = $user->createToken('abcd')->plainTextToken;
        $success['name'] = $user->name;

        $response = [
            'success' => true,
            'data' => $success,
            'message' => 'user registered successfully'
        ];
        return response()->json($response, 200);
    }

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required | email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }
        if (Auth::attempt([
            'email' => $request->email, 
            'password' => $request->password
            ])
        ) {
            // /** @var \App\Models\User $user **/
            $user = Auth::user();
            $success['token'] = $user->createToken('abcd')->plainTextToken;
            $success['user'] = $user;

            $response = [
                'success' => true,
                'data' => $success,
                'message' => 'user logged in successfully'
            ];
            return response()->json($response,200);
        } else {
            $response = [
                'success' => false,
                'message' => 'Unauthorised!'
            ];
            return response()->json($response);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        $response = [
            'success' => true,
            'message' => 'user logged out successfully'
        ];

        return response()->json($response);
    }

    public function deleteAcc(Request $request) {
        $id = $request->input('key');
        $user = User::find($id);
        $request->user()->currentAccessToken()->delete();
        if ($user->delete()) {
            return response()->json(['deleted']);
        }
    }
    
    public function updateProfile(Request $request) {
        // return $request['name'];
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required | email',
        ]);
        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }
        $user = $request->user();
        $input = $request->only('name','email');
        $user->update($input);
        return response()->json($user);
    }
}
