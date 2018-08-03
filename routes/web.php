<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'News\NewsController@showNews');
Route::get('/news', 'News\NewsController@showNews');
Route::get('/news/view/{id}', 'News\NewsController@showNewsDetail');

Route::get('/login', 'User\UserController@showLogin')->name('login');
Route::post('/login', 'User\UserController@login');
Route::get('/register', 'User\UserController@showCreateUser')->name('register');
Route::post('/user/create', 'User\UserController@createUser');

Route::get('/user/password/reset', 'User\PasswordController@showResetPassword');
Route::post('/user/password/reset', 'User\PasswordController@resetPassword');
Route::get('/user/password/reset/{token}', 'User\PasswordController@showRenewPasswordForm')->name('password.reset');
Route::post('/user/password/new', 'User\PasswordController@createNewPassword');

Route::group(['middleware' => ['auth']], function () {
  Route::post('/news/create', 'News\NewsController@createNews');
  Route::get('/news/create', 'News\NewsController@showCreateNews');
  Route::get('/news/edit/{id}', 'News\NewsController@showEditNews');
  Route::patch('/news/update/{id}', 'News\NewsController@updateNews');
  Route::delete('/news/delete/{id}', 'News\NewsController@deleteNews');

  Route::get('/profile', 'User\UserController@showUserDetail');
  Route::get('/user/edit', 'User\UserController@showEditUser');
  Route::post('/user/update', 'User\UserController@updateUser');
  Route::delete('/user/deactivate', 'User\UserController@deleteUser');
  Route::get('/user/password/change', 'User\PasswordController@showChangePassword');
  Route::post('/user/password/change', 'User\PasswordController@changePassword');
  Route::get('/logout', 'User\UserController@logout');
});
