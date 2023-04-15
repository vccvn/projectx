<?php

namespace App\Http\Controllers\Apis\Crazy3D;

use App\Http\Controllers\Apis\ApiController;

use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\Users\UserRepository;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends ApiController
{
    protected $module = 'auth';

    protected $moduleName = 'Auth';

    protected $flashMode = true;

    /**
     * repository chinh
     *
     * @var UserRepository
     */
    public $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
        $this->init();
    }


    /**
     * @var bool
     */
    public $loginAfterSignUp = true;

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $input = $request->only('email', 'password');
        $token = null;

        if (!$token = JWTAuth::attempt($input)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid Email or Password',
            ], 401);
        }

        $user = $this->repository->findBy('email', $request->email);
        return response()->json([
            'status' => true,
            'token' => $token,
            'expiresIn' => 36000,
            'accessToken' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name
            ]
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function logout(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        try {
            JWTAuth::invalidate($request->token);

            return response()->json([
                'status' => true,
                'message' => 'User logged out successfully'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'status' => false,
                'message' => 'Sorry, the user cannot be logged out'
            ], 500);
        }
    }
}
