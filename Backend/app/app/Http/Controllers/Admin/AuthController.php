<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function login(Request $request){
        $validator = Validator::make($request->only('username','password'), [
            'username' => 'string|required|min:8|max:25',
            'password' => 'string|required|min:8|max:25',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(),404);
        } else {
            $user = User::where('name', $request->username)->where('username',$request->password)->where('admin', 1)->first();
            if($user){
                return response(['user' => $user, 'token' => $user->createToken('my_admin_token')->plainTextToken], 201);
            }else{
                return http_response_code(404);
            }
        }
    }
}
