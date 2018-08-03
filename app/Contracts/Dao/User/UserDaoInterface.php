<?php

namespace App\Contracts\Dao\User;

interface UserDaoInterface
{
    public function showUsers();
    public function showUserDetail($userId);
    public function createUser($userObj);
    public function updateUser($userId, $userObj);
    public function changePasswordByID($userId, $newPassword);
    public function changePasswordByEmail($userEmail, $newPassword);
    public function deleteUser($userId);
    public function isUserExist($userEmail);
    public function checkPassword($userId, $userPassword);
}
