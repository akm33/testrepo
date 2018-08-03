<?php

namespace App\Contracts\Services\PW_Resets;

interface PW_ResetsServiceInterface
{
  public function createToken($userEmail);
  public function getTokenData($token);
  public function deleteToken($token);
  public function sendPasswordResetMail($recipientMail, $passwordResetUrl);
}
