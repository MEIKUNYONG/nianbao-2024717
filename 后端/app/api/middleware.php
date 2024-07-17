<?php
// +----------------------------------------------------------------------
// | 全局中间件定义文件
// +----------------------------------------------------------------------

return [
    // // 环境检测
    // app\api\middleware\AppCheck::class,
    // // 登录检测
    // app\api\middleware\LoginCheck::class,
    app\api\middleware\Cross::class,
];
