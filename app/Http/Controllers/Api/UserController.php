<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Services\User\UserServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Tymon\JWTAuth\Exceptions\JWTException;
use Carbon\Carbon;
use JWTAuth;
use Validator;

class UserController extends Controller
{
    private $userService;

    /**
     * Constructor
     * @method __construct
     * @param  UserServiceInterface $userService
     */
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Show User profile
     * @method showUserDetail
     * @return void
     */
    public function showUserDetail()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $user = $this->userService->showUserDetail($user->id);
        return response()->json(['userData' => $user]);
    }

    /**
     * Create User
     * @method createUser
     * @param  Request $request
     * @return void
     */
    public function createUser(Request $request)
    {
        $userObj = $this->getUserClass($request);
        $result = $this->userService->createUser($userObj);
        if (!$result) {
            return response()->json(['success' => false, 'error' => config('constants.MSG_REG_FAIL')]);
        }
        return response()->json(['success' => true, 'msg' => 'Register Success, Login Now']);
    }

    /**
     * Update User
     * @method updateUser
     * @param  Request $request
     * @return void
     */
    public function updateUser(Request $request)
    {
        $validator = $this->validateUpdate($request);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $userObj = $this->getUserClass($request);
        $this->userService->updateUser(Auth::user()->id, $userObj);
        return redirect('/profile')->with('msg', config('constants.MSG_UPDATE_USER_SUCCESS'));
    }

    /**
     * Delete User with softdeletes
     * It can be restored
     *
     * @param Request $request
     * @return void
     */
    public function deleteUser(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $this->userService->deleteUser($user->id);
        JWTAuth::invalidate($request->input('token'));
  			return response()->json(['success' => true, 'message' => "Deactivated User"]);
    }

    /**
     * User Log in
     * @method login
     * @param  Request $request
     * @return void
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $expired = Carbon::now()->addDays(7)->timestamp;
        try {
    			if (!$token = JWTAuth::attempt($credentials, ['exp' => $expired])) {
    				return response()->json(['success' => false, 'error' => 'We cant find an account with this credentials.']);
    			}
    		} catch (JWTException $e) {
    			return response()->json(['success' => false, 'error' => 'Failed to login, please try again.'], 500);
    		}
        $user = JWTAuth::setToken($token)->toUser();
    		return response()->json(['success' => true, 'data' => ['token' => $token, 'expired' => $expired], 'userData' => $user]);
    }

    public function checkLogin(Request $request)
    {
      try {
        if (! $user = JWTAuth::parseToken()->authenticate()) {
          return response()->json(['success' => false, 'error' => 'user not found'], 404);
        }
      } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
          return response()->json(['success' => false, 'error' => 'token expired']);
      } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
          return response()->json(['success' => false, 'error' => 'invalid token']);
      } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
          return response()->json(['success' => false, 'error' => 'invalid token']);
      }

      return response()->json(['success' => true, 'msg' => 'Logged In', 'userData' => $user]);
    }

    /**
     * User Log out
     * @method logout
     * @return void
     */
    public function logout(Request $request)
    {
  		try {
  			JWTAuth::invalidate($request->input('token'));
  			return response()->json(['success' => true, 'message' => "You have successfully logged out."]);
  		} catch (JWTException $e) {
  			return response()->json(['success' => false, 'error' => 'Failed to logout, please try again.'], 500);
  		}
    }

    /**
     * create User Object
     * @method getUserClass
     * @param  Request $request
     * @return Object
     */
    private function getUserClass($request)
    {
        $userObj = new \stdClass();
        $userObj->name = trim($request->name);
        $userObj->email = trim($request->email);
        $userObj->password = trim($request->password);
        $userObj->gender = $request->gender;
        $userObj->address = $request->address;
        return $userObj;
    }

    /**
     * Validate Log in form
     * @method validateLogin
     * @param  Request $request
     * @return Validator
     */
    private function validateLogin(Request $request)
    {
        return $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
    }

    /**
     * Validate Update form
     * @method validateUpdate
     * @param  Request $request
     * @return Validator
     */
    private function validateUpdate(Request $request)
    {
        return $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:150',
            'email' => 'required|email',
            'address' => 'required|max:255',
        ]);
    }

    /**
     * Validate Register form
     * @method validateCreateUser
     * @param  Request $request
     * @return Validator
     */
    private function validateCreateUser(Request $request)
    {
        return $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:user',
            'password' => 'required|min:6|max:20|string',
            'address' => 'required|max:255',
        ]);
    }

}
