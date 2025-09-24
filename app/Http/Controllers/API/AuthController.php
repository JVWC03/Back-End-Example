<?php 

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use App\Http\Controllers\API\BaseController;

use Validator;

class AuthController extends BaseController {
    public function register(Request $request): JsonResponse{
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'c_password' => 'required|same:password',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 422);       
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $token = $user->createToken('auth_token')->plainTextToken;

        $success = [
            'token' => $token,
            'name' => $user->name
        ];

        return $this->sendResponse($success, 'User registered successfully.');
    }

    public function login(Request $request): JsonResponse{
        
        if(!Auth::attempt(['email' => $request['email'], 'password' => $request['password']])){
            $user = Auth ::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            $success = [
                'token' => $token,
                'name' => $user->name
            ];

            return $this->sendResponse($success, 'User logged in successfully.');
        }
        else {
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised'], 401);
        }
    }
}