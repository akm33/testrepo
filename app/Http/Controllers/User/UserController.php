<?php

namespace App\Http\Controllers\User;

use App\Contracts\Services\User\UserServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Session;
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
        $user = $this->userService->showUserDetail(Auth::user()->id);
        return view('users.show', compact('user'));
    }

    /**
     * Show Create Form for user
     * @method showCreateUser
     * @return void
     */
    public function showCreateUser()
    {
        return view('users.create');
    }

    /**
     * Create User
     * @method createUser
     * @param  Request $request
     * @return void
     */
    public function createUser(Request $request)
    {
        $validator = $this->validateCreateUser($request);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $userObj = $this->getUserClass($request);
        $result = $this->userService->createUser($userObj);
        if (!$result) {
            return redirect()->back()->with('error', config('constants.MSG_REG_FAIL'));
        }
        $this->userService->login($userObj, false);
        return redirect('/');
    }

    /**
     * Show Edit form for user
     * @method showEditUser
     * @return void
     */
    public function showEditUser()
    {
        $user = $this->userService->showUserDetail(Auth::user()->id);
        return view('users.edit', compact('user'));
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
        $this->userService->deleteUser(Auth::user()->id);
        return redirect('/');
    }

    /**
     * Show Log in form
     * @method showLogin
     * @return void
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->back();
        }
        return view('users.login');
    }

    /**
     * User Log in
     * @method login
     * @param  Request $request
     * @return void
     */
    public function login(Request $request)
    {
        $validator = $this->validateLogin($request);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $userObj = $this->getUserClass($request);
        $remember = (is_null($request->remember)) ? false : true;
        $result = $this->userService->login($userObj, $remember);
        if (!$result) {
            return redirect()->back()->with('error', config('constants.MSG_LOGIN_FAIL'));
        }
        $request->session()->regenerate();
        return redirect('/');
    }

    /**
     * User Log out
     * @method logout
     * @return void
     */
    public function logout()
    {
        $this->userService->logout();
        return redirect('/');
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
