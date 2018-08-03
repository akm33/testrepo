<?php

namespace App\Services\User;

use App\Contracts\Dao\User\UserDaoInterface;
use App\Contracts\Services\User\UserServiceInterface;
use Illuminate\Support\Facades\Auth;

class UserService implements UserServiceInterface
{
    private $userDao;

    /**
     * Constructor
     * @method __construct
     * @param  UserDaoInterface $userDao
     */
    public function __construct(UserDaoInterface $userDao)
    {
        $this->userDao = $userDao;
    }

    /**
     * Show all user on database
     * @method showUsers
     * @return void
     */
    public function showUsers()
    {
        return $this->userDao->showUsers();
    }

    /**
     * Show user profile
     * @method showUserDetail
     * @param  int $userId
     * @return void
     */
    public function showUserDetail($userId)
    {
        return $this->userDao->showUserDetail($userId);
    }

    /**
     * create new user
     * @method create
     * @param  Object $userObj user info data
     * @return void
     */
    public function createUser($userObj)
    {
        return $this->userDao->createUser($userObj);
    }

    /**
     * Update user by id
     * @method updateUser
     * @param  int $userId
     * @param  Object $userObj Updated User data
     * @return void
     */
    public function updateUser($userId, $userObj)
    {
        return $this->userDao->updateUser($userId, $userObj);
    }

    /**
     * Change Password by id from old password
     * @method changePassword
     * @param  int $userId
     * @param  string $oldPassword
     * @param  string $newPassword
     * @return null
     */
    public function changePassword($userId, $oldPassword, $newPassword)
    {
        if(!$this->userDao->checkPassword($userId, $oldPassword)) {
            return false;
        }
        return $this->userDao->changePasswordByID($userId, $newPassword);
    }

    /**
     * Create New password or reset password
     * @method createNewPassword
     * @param  string $userEmail
     * @param  string $newPassword
     * @return null
     */
    public function changePasswordByEmail($userEmail, $newPassword)
    {
        return $this->userDao->changePasswordByEmail($userEmail, $newPassword);
    }

    /**
     * Delete user by id
     * @method deleteUser
     * @param  int $userId
     * @return void
     */
    public function deleteUser($userId)
    {
        $this->userDao->deleteUser($userId);
    }

    /**
     * Check user registered
     *
     * @param string $userEmail
     * @return boolean
     */
    public function isUserExist($userEmail)
    {
        return $this->userDao->isUserExist($userEmail);
    }

    /**
     * User log in
     * @method login
     * @param  Object $userObj User log in info
     * @param  boolean $remember
     * @return void
     */
    public function login($userObj, $remember)
    {
        return Auth::attempt(
            ['email' => $userObj->email,
             'password' => $userObj->password],
            $remember
        );
    }

    /**
     * User log out
     * @method logout
     * @return void
     */
    public function logout()
    {
        Auth::logout();
    }
}
