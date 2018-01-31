<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use App\Api\V1\Requests\LoginRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Auth;
use Image;

class UserController extends Controller
{
    private $currentUser;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', []);
        $this->currentUser = Auth::guard()->user();
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json($this->currentUser);
    }

    public function updateAccount(Request $request)
    {
        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300, 300)->save( public_path('/uploads/avatars/' . $filename ) );

            $user = $this->currentUser;
            $user->avatar = $filename;
            $user->save();
            return response()->json([
                'message' => 'Updated'
            ]);
        }
        return response()->json([
            'error' => [
                'message' => 'Cannot upload avatar',
                'status_code' => 500
            ]
        ], 500);
    }
}
