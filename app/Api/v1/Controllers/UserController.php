<?php

namespace App\Api\v1\Controllers;

/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 2017/5/3
 * Time: 下午5:11
 */
use App\model\Users;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    /**
     * 用户注册
     * @param String $password 密码
     * @param String $password_confirmation 确定密码
     * @param String $email 邮箱
     * @return Response.json
     */
    public function register(Request $request)
    {
        // 数据验证
        $validator = app('validator')->make($request->all(), Users::$rules);
        if ($validator->fails()) {
            return $this->error(0, current($validator->errors()));
        }
        $user = new Users();
        $user->email = $request->email;
        $user->password = app('hash')->make($request->password);
        $data = $user->save();
        if ($data) {
            try {
                $payload = app('request')->only('email', 'password');
                $token = JWTAuth::attempt($payload);
            } catch (JWTException $e) {
                return $this->error(400101, '创建Token失败');
            }
            return $this->success(['user' => $user, 'token' => $token],1,'注册成功');
        } else {
            return $this->error(0, '注册失败');
        }
    }

    /**
     * 用户登录
     * @param Number $mail 邮箱
     * @param String $password 密码
     * @param String $nickname 用户昵称
     * @return Response.json
     */
    public function login()
    {
        // 验证规则
        $rules = array(
            'email' => array('required', 'email'),
            'password' => array('required', 'alpha_dash'),
        );
        $payload = app('request')->only('email', 'password');
        // 验证格式
        $validator = app('validator')->make($payload, $rules);
        if ($validator->fails()) {
            return response()->json(
                array(
                    'errcode' => -2,
                    'errmsg' => $validator->errors()
                ), 200);
        }
        $user = Users::where('email', '=', $payload['email'])->first();
        if (!$user) {
            return response()->json(array(
                'errcode' => 400104,
                'errmsg' => '用户不存在'
            ), 404);
        }
        try {
            if (!$token = JWTAuth::attempt($payload)) {
                return response()->json(array(
                    'errcode' => 400103,
                    'errmsg' => '密码错误或账号无效'
                ));
            }
        } catch (JWTException $e) {
            return response()->json(
                array(
                    'errcode' => 400102,
                    'errmsg' => '创建Token失败'
                ));
        }
        return response()->json(
            array(
                'errcode' => 0,
                'errmsg' => '登录成功',
                'data' => array(
                    'token' => $token,
                    'user' => $user
                )
            ));
    }

    /**
     * 更新用户 token
     * @return Response.json
     */
    public function upToken()
    {
        $token = JWTAuth::refresh();
        return response()->json(
            array(
                'errcode' => 0,
                'errmsg' => '更新成功',
                'data' => array(
                    'token' => $token,
                    'time' => time()
                )
            ));
    }

    /**
     * 登出处理
     * @return Response.json
     */
    public function logout()
    {
        if (JWTAuth::invalidate()) {
            return response()->json(
                array(
                    'errcode' => 0,
                    'errmsg' => '退出成功'
                ));
        }
        return response()->json(
            array(
                'errcode' => 400102,
                'errmsg' => '退出失败'
            ));
    }

    public function index()
    {
        $users= Users::all();
        return $this->success($users);
    }

    public function show($id)
    {
        $user = Users::findOrFail($id);
        return $this->success($user);
    }

}