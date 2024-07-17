<?php
/**
 * +———————————————————————-
 * | Api中间件
 * +———————————————————————-
 */

namespace app\api\middleware;


use think\facade\Request;
use think\Response;
use think\exception\HttpResponseException;

use think\exception\ValidateException;

class Cross
{
 
    public function handle($request, \Closure $next)
    {
        //允许的源域名
        header("Access-Control-Allow-Origin: *");
        //允许的请求头信息
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization, Token");
        //允许的请求类型
        header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE,OPTIONS,PATCH');
        
        if($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
            exit();
        }
        return $next($request);

    }
}

