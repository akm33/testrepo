<?php

namespace App\Http\Controllers\Api;

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
     * change Password function
     * @method changePassword
     * @param Request $request
     * @return void
     */
    public function changePassword(Request $request)
    {

        $result = $this->userService->changePassword(Auth::user()->id, $request->oldPassword, $request->newPassword);
        if (!$result) {
            return redirect()->back()->with('error', config('constants.MSG_INCORRECT_OLD_PW'));
        } elseif (is_null($result)) {
            return redirect()->back()->with('error', config('constants.MSG_CHANGE_PW_FAIL'));
        }
        return redirect('/profile')->with('msg', config('constants.MSG_CHANGE_PW_SUCCESS'));
    }


    /**
     * Reset Password
     * @method resetPassword
     * @param  Request $request
     */
    public function resetPassword(Request $request)
    {
        if (!$this->userService->isUserExist($request->email)) {
            return response()->json(['success' => true, 'msg' => config('constants.MSG_PW_RESET_SENT')]);
        }
        $token = $this->PW_ResetsService->createToken($request->email);
        if (is_null($token)) {
            return response()->json(['success' => false, 'msg' => 'System Error']);
        }
        $passwordResetUrl = config('constants.CLIENT_URL').'password/reset?token='.$token;
        $this->PW_ResetsService->sendPasswordResetMail($request->email, $passwordResetUrl);
        return response()->json(['success' => true, 'msg' => config('constants.MSG_PW_RESET_SENT')]);
    }

    /**
     * Show Form to renew password
     * @method showRenewPasswordForm
     * @param  string $token
     * @return void
     */
    public function checkResetToken(Request $request)
    {
        $tokenData = $this->PW_ResetsService->getTokenData($request->token);
        if (is_null($tokenData)) {
            return response()->json(['success' => false, 'msg' => config('constants.MSG_TOKEN_INVALID')]);
        } elseif ($tokenData->expired_at < date('Y-m-d H:i:s')) {
            $this->PW_ResetsService->deleteToken($request->token);
            return response()->json(['success' => false, 'msg' => config('constants.MSG_TOKEN_EXPIRED')]);
        }
        return response()->json(['success' => true, 'msg' => 'Token is valid.']);
    }

    /**
     * Create New Password
     * @method createNewPassword
     * @param  Request $request
     * @return void
     */
    public function createNewPassword(Request $request)
    {
        $tokenData = $this->PW_ResetsService->getTokenData($request->token);
        if (is_null($tokenData)) {
            return response()->json(['success' => false, 'msg' => 'Invalid Token.']);
        }
        $this->userService->changePasswordByEmail($tokenData->email, $request->password);
        $this->PW_ResetsService->deleteToken($tokenData->token);

        return response()->json(['success' => true, 'msg' => config('constants.MSG_PW_RESET_FINISH')]);
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
