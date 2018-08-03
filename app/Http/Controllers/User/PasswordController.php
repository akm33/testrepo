<?php

namespace App\Http\Controllers\User;

use App\Contracts\Services\PW_Resets\PW_ResetsServiceInterface;
use App\Contracts\Services\User\UserServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class PasswordController extends Controller
{
    private $userService;
    private $PW_ResetsService;

    /**
     * Constructor
     * @param UserServiceInterface $userService
     * @param PW_ResetsServiceInterface $PW_ResetsService
     */
    public function __construct(UserServiceInterface $userService, PW_ResetsServiceInterface $PW_ResetsService)
    {
        $this->userService = $userService;
        $this->PW_ResetsService = $PW_ResetsService;
    }

    /**
     * show password change form
     * @method showChangePassword
     * @return void
     */
    public function showChangePassword()
    {
        return view('users.password.change');
    }

    /**
     * change Password function
     * @method changePassword
     * @param Request $request
     * @return void
     */
    public function changePassword(Request $request)
    {
        $validator = $this->validatePassword($request);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        if ($request->oldPassword === $request->newPassword) {
            return redirect()->back()->with('error', config('constants.MSG_SAME_PW'));
        }
        $result = $this->userService->changePassword(Auth::user()->id, $request->oldPassword, $request->newPassword);
        if (!$result) {
            return redirect()->back()->with('error', config('constants.MSG_INCORRECT_OLD_PW'));
        } elseif (is_null($result)) {
            return redirect()->back()->with('error', config('constants.MSG_CHANGE_PW_FAIL'));
        }
        return redirect('/profile')->with('msg', config('constants.MSG_CHANGE_PW_SUCCESS'));
    }

    /**
     * Show form email input for reset password
     * @method showResetPassword
     * @return view
     */
    public function showResetPassword()
    {
        return view('users.password.reset');
    }

    /**
     * Reset Password
     * @method resetPassword
     * @param  Request $request
     */
    public function resetPassword(Request $request)
    {
        if (!$this->userService->isUserExist($request->email)) {
            return view('users.password.finish')->with('msg', config('constants.MSG_PW_RESET_SENT'));
        }
        $token = $this->PW_ResetsService->createToken($request->email);
        if (is_null($token)) {
            return view('errors.500');
        }
        $passwordResetUrl = route('password.reset', ['token' => $token]);
        $this->PW_ResetsService->sendPasswordResetMail($request->email, $passwordResetUrl);
        return view('users.password.finish')->with('msg', config('constants.MSG_PW_RESET_SENT'));
    }

    /**
     * Show Form to renew password
     * @method showRenewPasswordForm
     * @param  string $token
     * @return void
     */
    public function showRenewPasswordForm($token)
    {
        $tokenData = $this->PW_ResetsService->getTokenData($token);
        if (is_null($tokenData)) {
            return view('users.password.renew')->with('error', config('constants.MSG_TOKEN_INVALID'));
        } elseif ($tokenData->expired_at < date('Y-m-d H:i:s')) {
            $this->PW_ResetsService->deleteToken($token);
            return view('users.password.renew')->with('error', config('constants.MSG_TOKEN_EXPIRED'));
        }
        return view('users.password.renew', compact('token'));
    }

    /**
     * Create New Password
     * @method createNewPassword
     * @param  Request $request
     * @return void
     */
    public function createNewPassword(Request $request)
    {
        $validator = $this->validatePasswordReset($request);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $tokenData = $this->PW_ResetsService->getTokenData($request->token);
        if (is_null($tokenData)) {
            return view('errors.500');
        }
        $this->userService->changePasswordByEmail($tokenData->email, $request->password);
        $this->PW_ResetsService->deleteToken($tokenData->token);
        return view('users.password.finish')->with('msg', config('constants.MSG_PW_RESET_FINISH'));
    }

    /**
     * Validation for password
     * @method validatePassword
     * @param  Request $request
     * @return Validator $validator
     */
    private function validatePassword(Request $request)
    {
        return $validator = Validator::make($request->all(), [
            'oldPassword' => 'required|string',
            'newPassword' => 'required|min:6|max:20|string',
        ]);
    }

    /**
     * Validation for password reset
     * @method validatePasswordReset
     * @param  Request $request
     */
    private function validatePasswordReset(Request $request)
    {
        return $validator = Validator::make($request->all(), [
            'password' => 'required|min:6|max:20|string',
        ]);
    }

}
