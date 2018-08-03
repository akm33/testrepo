<?php

namespace App\Dao\User;

use App\Contracts\Dao\User\UserDaoInterface;
use App\Models\User;
use Hash;

class UserDao implements UserDaoInterface
{
    /**
     * show all users
     * @method showUsers
     * @return void
     */
    public function showUsers()
    {
        return User::paginate(config('constants.PAGINATION'));
    }

    /**
     * Show user profile
     * @method showUserDetail
     * @param  int $userId
     * @return User
     */
    public function showUserDetail($userId)
    {
        return User::where('id', $userId)->first();
    }

    /**
     * create user function
     * @method create
     * @param  Object $userObj
     * @return void
     */
    public function createUser($userObj)
    {
        return User::create([
            'name' => $userObj->name,
            'email' => $userObj->email,
            'password' => Hash::make($userObj->password),
            'gender' => $userObj->gender,
            'address' => $userObj->address,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * update user by id
     * @method updateUser
     * @param  int $userId [description]
     * @param  Object $userObj [description]
     * @return void
     */
    public function updateUser($userId, $userObj)
    {
        User::where('id', $userId)
            ->update([
                'name' => $userObj->name,
                'email' => $userObj->email,
                'gender' => $userObj->gender,
                'address' => $userObj->address,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
    }

    /**
     * change Password
     *
     * @param int $userId
     * @param string $oldPassword
     * @param string $newPassword
     * @return null
     */
    public function changePasswordByID($userId, $newPassword)
    {
        $result = User::where('id', $userId)->update([
            'password' => Hash::make($newPassword),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        return $result;
    }

    /**
     * create new Password
     *
     * @param string $userEmail
     * @param string $newPassword
     * @return null
     */
    public function changePasswordByEmail($userEmail, $newPassword)
    {
        $result = User::where('email', $userEmail)->update([
            'password' => Hash::make($newPassword),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        return $result;
    }

    /**
     * delete User by id
     * @method deleteUser
     * @param  int $userId [description]
     * @return void
     */
    public function deleteUser($userId)
    {
        User::where('id', $userId)->delete();
    }

    /**
     * check user existing by email
     *
     * @param string $userEmail
     * @return boolean
     */
    public function isUserExist($userEmail)
    {
        if (User::where('email', $userEmail)->count() == 0) {
            return false;
        }
        return true;
    }

    /**
     * Check user password
     *
     * @param [type] $password
     * @return void
     */
    public function checkPassword($userId, $userPassword)
    {
        $user = User::where('id', $userId)->first();
        if (Hash::check($userPassword, $user->password)) {
            return true;
        }
        return false;
    }
}
