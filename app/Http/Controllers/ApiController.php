<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 2017/4/26
 * Time: 下午10:42
 */

namespace App\Http\Controllers;


use Dingo\Api\Routing\Helpers;

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
    public function error($code = 0)
    {
        $nullObj = new \stdClass();
        return $this->response->array(['status' => 0, 'msg' => trans("message.$code"), 'code' => $code, 'data' => $nullObj]);
    }

}