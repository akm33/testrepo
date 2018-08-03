<?php

namespace App\Contracts\Dao\PW_Resets;

interface PW_ResetsDaoInterface
{
  public function createToken($userEmail);
  public function getTokenData($token);
  public function deleteToken($token);
}
