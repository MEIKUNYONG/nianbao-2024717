<?php 

declare (strict_types = 1);

namespace app\api\middleware;

use app\api\model\User;
use app\api\model\UserToken;
/**
 * 用户鉴权（按需引入中间件）
 */
class AuthCheck
{
    public function handle($request, \Closure $next)
    {
        if (! $request->userInfo) {
            return json(['status'=>'login', 'message'=> '请登录后操作！']);
        }
        // 下一步
        return $next($request);
    }
}