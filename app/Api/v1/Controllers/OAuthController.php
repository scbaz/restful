<?php

namespace App\Api\v1\Controllers;

/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 2017/5/3
 * Time: 下午5:16
 */
use Dingo\Api\Auth\Provider\Authorization;
use Illuminate\Routing\Controller;
use LucaDegasperi\OAuth2Server\Authorizer;

class OAuthController extends ApiController
{

    public function accesstoken()
    {
        $oauth=new Authorizer();
    }

}