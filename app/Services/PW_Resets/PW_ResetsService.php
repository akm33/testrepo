<?php

namespace App\Services\PW_Resets;

use App\Contracts\Dao\PW_Resets\PW_ResetsDaoInterface;
use App\Contracts\Services\PW_Resets\PW_ResetsServiceInterface;
use Illuminate\Support\Facades\Mail;

class PW_ResetsService implements PW_ResetsServiceInterface
{
    private $PW_ResetsDao;

    /**
     * Constructor
     * @method _construct
     * @param  PW_ResetsDaoInterface $PW_Resets
     * @return void
     */
    public function __construct(PW_ResetsDaoInterface $PW_ResetsDao)
    {
        $this->PW_ResetsDao = $PW_ResetsDao;
    }

    /**
     * Create Token for password Reset
     * @method createToken
     * @param string $userEmail
     * @return string $token
     */
    public function createToken($userEmail)
    {
        return $this->PW_ResetsDao->createToken($userEmail);
    }

    /**
     * get Token Data
     * @method getTokenData
     * @param  String $token
     * @return void
     */
    public function getTokenData($token)
    {
        return $this->PW_ResetsDao->getTokenData($token);
    }

    /**
     * delete Token
     * @method deleteToken
     * @param  string $token
     * @return void
     */
    public function deleteToken($token)
    {
        $this->PW_ResetsDao->deleteToken($token);
    }

    /**
     * Send Mail for password reset link
     * @method sendPasswordResetMail
     * @param  string $recipientMail
     * @param  string $passwordResetUrl
     */
    public function sendPasswordResetMail($recipientMail, $passwordResetUrl)
    {
        Mail::raw([], function ($message) use ($recipientMail, $passwordResetUrl) {
            $message->from(config('constants.MAIL_SENDER'));
            $message->to($recipientMail);
            $message->subject('Reset Password');
            $message->setBody('Password Reset Link : ' . $passwordResetUrl, 'text/plain');
        });
    }

}
