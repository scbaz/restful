<?php
namespace App\Api\v1\Controllers;

/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 2017/5/3
 * Time: 下午5:09
 */
use Dingo\Api\Routing\Helpers;
use JWTAuth;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    use Helpers;

    /**
     * 请求成功返回
     * @param array $data
     * @param int $code
     * @return mixed
     */
    public function success($data = [], $code = 1)
    {
        $data = empty($data) ? new \stdClass() : $data;
        return $this->response->array(['status' => 1, 'msg' => trans("message.$code"), 'code' => $code, 'data' => $data]);
    }

    /**错误信息提示
     * @param int $code
     * @return mixed
     */
    public function error($code = 0,$msg='')
    {
        $nullObj = new \stdClass();
        $msg=empty($msg)?trans("message.$code"):$msg;
        return $this->response->array(['status' => 0, 'msg' => $msg, 'code' => $code, 'data' => $nullObj]);
    }
}