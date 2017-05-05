<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 2017/4/26
 * Time: 下午10:29
 */

namespace App\Http\Controllers;

use App\User;


class UsersController extends ApiController
{
    public function index()
    {
        return User::all();
    }

    public function show($id)
    {
        $user= User::findOrFail($id);
        return $this->success($user);
    }

    public function store(){

    }

}