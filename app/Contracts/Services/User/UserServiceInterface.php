<?php

namespace App\Contracts\Services\User;

interface UserServiceInterface
{
    public function showUsers();
    public function showUserDetail($userId);
    public function createUser($userObj);
    public function updateUser($userId, $userObj);
    public function changePassword($userId, $oldPassword, $newPassword);
    public function changePasswordByEmail($userEmail, $newPassword);
    public function deleteUser($userId);
    public function isUserExist($userEmail);
    public function login($userObj, $remember);
    public function logout();
}
