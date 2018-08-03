<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['api', 'cors']], function ($router) {
  Route::group(['middleware' => ['jwt.auth']], function() {
      Route::get('deactivate', 'Api\UserController@deleteUser');
      Route::get('logout', 'Api\UserController@logout');
      Route::get('profile', 'Api\UserController@showUserDetail');
      Route::get('test', function(){
          return response()->json(['foo'=>'bar']);
      });
  });

  Route::get('/login/check', 'Api\UserController@checkLogin');
  Route::post('/login', 'Api\UserController@login');
  Route::post('/register', 'Api\UserController@createUser');
  Route::post('/password/reset', 'Api\PasswordController@resetPassword');
  Route::post('/password/resettoken/check', 'Api\PasswordController@checkResetToken');
  Route::post('/password/createnew', 'Api\PasswordController@createNewPassword');

  Route::get('/news', 'Api\NewsController@showNews');
  Route::post('/news/create', 'Api\NewsController@createNews');
  Route::get('/news/{id}', 'Api\NewsController@getNewsDetail');
  Route::post('/news/update/{id}', 'Api\NewsController@updateNews');
  Route::delete('/news/delete/{id}', 'Api\NewsController@deleteNews');
});
