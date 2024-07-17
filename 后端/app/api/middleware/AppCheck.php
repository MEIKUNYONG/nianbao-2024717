<?php 

declare (strict_types = 1);

namespace app\api\middleware;
/**
 * 环境检测
 */
class AppCheck
{
    public function handle($request, \Closure $next)
    {
    	// 路由信息
        $request->pathinfo = str_replace('.html', '', $request->pathinfo());
        $request->pathArr = explode('/', $request->pathinfo);
        $request->path = $request->pathArr[0];
        // 绑定事件
        event('AppCheck', $request);
        // 下一步
        return $next($request);
    }
}