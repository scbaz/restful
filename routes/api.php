<?php

use Illuminate\Http\Request;
use \Dingo\Api\Http\Response;

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

$api = app('Dingo\Api\Routing\Router');

// 配置api版本和路由
$api->version('v1', function ($api) {
    $api->group(['namespace' => 'App\Api\v1\Controllers'], function ($api) {

        $api->group(['prefix' => 'user'], function ($api) {
            $api->post('register', 'UserController@register');   # 注册
            $api->post('login', 'UserController@login');        # 登录
        });

        #需要验证
        $api->group(['middleware' => ['jwt.auth']], function ($api) {
            $api->group(['prefix' => 'user'], function ($api) {
                $api->get('logout', 'AuthenticateController@logout');       # 退出登录
                $api->get('show/{id}', 'UserController@show');                        # 查看个人信息
                $api->get('index', 'UserController@index');                        # 查看个人信息

            });
        });
    });
});
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// middleware auth todo
// 可能需要去掉
// Route::get('oauth/authorize', ['as' => 'oauth.authorize.get','middleware' => ['check-authorization-params', 'auth'], function() {
Route::get('oauth/authorize', ['as' => 'oauth.authorize.get', 'middleware' => ['check-authorization-params'], function () {
    // display a form where the user can authorize the client to access it's data
    $authParams = Authorizer::getAuthCodeRequestParams();
    $formParams = array_except($authParams, 'client');
    $formParams['client_id'] = $authParams['client']->getId();
    return View::make('oauth.authorization-form', ['params' => $formParams, 'client' => $authParams['client']]);
}]);
// Route::post('oauth/authorize', ['as' => 'oauth.authorize.post','middleware' => ['csrf', 'check-authorization-params', 'auth'], function() {
Route::post('oauth/authorize', ['as' => 'oauth.authorize.post', 'middleware' => ['check-authorization-params'], function () {
    $params = Authorizer::getAuthCodeRequestParams();
    // add extra
    Auth::attempt(['email' => Input::get('email'), 'password' => Input::get('password')]);
    $params['user_id'] = Auth::user()->id;
    $redirectUri = '';
    // if the user has allowed the client to access its data, redirect back to the client with an auth code
    if (Input::get('approve') !== null) {
        $redirectUri = Authorizer::issueAuthCode('user', $params['user_id'], $params);
    }
    // if the user has denied the client to access its data, redirect back to the client with an error message
    if (Input::get('deny') !== null) {
        $redirectUri = Authorizer::authCodeRequestDeniedRedirectUri();
    }
    return Redirect::to($redirectUri);
}]);

Route::get('auth/login', 'MultiplexController@authLogin');
Route::get('redirect_url', 'MultiplexController@redirectUrl');

//Create a test user, you don't need this if you already have.
Route::get('/register', function () {
    $user = new App\User();
    $user->name = "tester";
    $user->email = "test@test.com";
    $user->password = \Illuminate\Support\Facades\Hash::make("password");
    $user->save();
});

$api = app('Dingo\Api\Routing\Router');

//Show user info via restful service.
$api->version('v1', function ($api) {
    // 用户注册
    $api->post('users', 'UserController@store');
    // 用户登录
    $api->get('oauth/access_token', 'App\Api\v1\Controllers\OAuthController@Accesstoken');
    // 退出登录
    $api->delete('oauth/invalidate_token', 'UserController@logout');
    //$api->get('users', 'UsersController@index');
    //$api->get('users/{id}', 'UsersController@show');
});

//Just a test with auth check.
$api->version('v1', ['middleware' => 'api.auth'], function ($api) {
    $api->get('time', function () {
        return ['now' => microtime(), 'date' => date('Y-M-D', time())];
    });
});*/

/*$api->version('v1', function ($api) {
    $api->get('user/{id}'		, 'App\Api\v1\Controllers\UserController@show');
    $api->get('users/'			, 'App\Api\v1\Controllers\UserController@index');
    $api->post('users/'			, 'App\Api\v1\Controllers\UserController@store');
    $api->delete('users/{id}'	, 'App\Api\v1\Controllers\UserController@destroy');
    $api->put('users/{id}'		, 'App\Api\v1\Controllers\UserController@update');
});*/
