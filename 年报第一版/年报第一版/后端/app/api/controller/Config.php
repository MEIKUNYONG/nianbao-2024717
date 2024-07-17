<?php 

declare (strict_types = 1);

namespace app\api\controller;

use app\api\BaseController;
use app\api\model\Themes;
use app\api\model\Config as ConfigModel;
/**
 * 配置信息
 */
class Config extends BaseController
{
	/**
     * 验证码
     */
    public function verify()
    {
        $code = strval(rand(1000, 9999));
        //返回数据 验证码图片路径、验证码标识
        $data = [
            'src'  => $this->request->domain().captcha_src() . '?code=' . $code,
            'code' => password_hash($code, PASSWORD_BCRYPT, ['cost' => 12])
        ];
        return json(['status' => 'success', 'message' => '获取成功', 'data' => $data]);
    }
    
	/**
	 * 基础信息
	 */
	public function index() 
	{
		if ($this->request->isPost()) {
			// 基础信息
	        $data = ConfigModel::getVal('system');
	        // 主题信息
	        $theme = Themes::where('name', theme())->cache('theme_' . theme())->field('config')->find();
	        foreach ($theme->config as $k => $v) { 
	            $data[$v['field']] = $v['type']['value'];
	        }
	        return json(['status' => 'success', 'message' => '获取成功', 'data' => $data]);
	    }
	}
}