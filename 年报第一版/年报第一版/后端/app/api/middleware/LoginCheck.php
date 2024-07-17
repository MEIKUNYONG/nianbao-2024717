<?php 

declare (strict_types = 1);

namespace app\api\middleware;

use app\api\model\User;
use app\api\model\UserToken;
/**
 * 登录检测
 */
class LoginCheck
{
    public function handle($request, \Closure $next)
    {
        $time  = 14*24; // 控制token过期时间(14天)
        $input = input('post.');
        if (! empty($input['token'])) {
            // token用户
            $id = UserToken::where("token", $input['token'])->whereTime("create_time","-$time hours")->order('create_time','desc')->value('user_id');
            if ($id) {
                // token用户信息
                $userInfo = User::with(['group'])->where('id', $id)->where('status', 1)->find();
                if ($userInfo) {
                    // token用户信息令牌比对
                    $userToken = $id . $request->ip() . $userInfo->password;
                    if (password_verify($userToken, $input['token'])) {
                        $userInfo->password = '';
                        $request->userInfo  = $userInfo;
                    }
                }
            }
        }
        // 下一步
        return $next($request);
    }
}