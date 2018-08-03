<?php

namespace App\Dao\PW_Resets;

use App\Contracts\Dao\PW_Resets\PW_ResetsDaoInterface;
use App\Models\PW_Resets;
use Carbon\Carbon;

class PW_ResetsDao implements PW_ResetsDaoInterface
{
    /**
     * Create Token for password Reset
     * @method createToken
     * @param  string $userEmail
     * @return string $token
     */
    public function createToken($userEmail)
    {
        PW_Resets::where('email', $userEmail)->delete();
        $token = str_random(config('constants.TOKEN_LENGTH'));
        $now = Carbon::now();
        $result = PW_Resets::create([
            'email' => $userEmail,
            'token' => $token,
            'created_at' => $now,
            'expired_at' => Carbon::parse($now)->addMinutes(config('constants.PW_RESET_TOKEN_DURATION')),
        ]);
        if (!$result) {
            return null;
        }
        return $token;
    }

    /**
     * Get Token data
     * @method getTokenData
     * @param  string $token
     * @return string
     */
    public function getTokenData($token)
    {
        return PW_Resets::where('token', $token)->first();
    }

    /**
     * delete TOKEN
     * @method deleteToken
     * @param  string $token
     * @return void
     */
    public function deleteToken($token)
    {
        PW_Resets::where('token', $token)->delete();
    }
}
