<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController as BaseController;

class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'image' => 'nullable',
            'password' => 'required',
            'confirmation_password' => 'required|same:password',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $input = $request->all();

        $path = 'profile/'.time().'.'.$request->file('image')->extension();
        $request->file('image')->move(public_path('profile'),$path);

        // $request->file('image')->store('profile', $path);

        $input['password'] = bcrypt($input['password']);
        $input['image'] = $path;

        $user = User::create($input);

        $success['name'] =  $user->name;
        $success['email'] = $user->email;
        $success['address'] = $user->address;
        $success['phone'] = $user->phone;
        $success['image'] = $user->image;

        return $this->sendResponse($success, 200, 'User register successfully.');
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['name'] =  $user->name;
            $success['email'] = $user->email;
            $success['address'] = $user->address;
            $success['phone'] = $user->phone;
            $success['image'] = $user->image;

            return $this->sendResponse($success, 200, 'User login successfully.');
        }
        else{
            return $this->sendError('Unauthorised.', 401, ['error'=>'Unauthorised']);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return $this->sendResponse([], 200, 'Logout Successful.');

    }

    public function get_user(Request $request)
    {
        $user = Auth::user();

        return $this->sendResponse($user, 200, 'Get User successfully.');
    }
}
