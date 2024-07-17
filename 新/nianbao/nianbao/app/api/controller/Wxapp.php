<?php 

declare (strict_types = 1);

namespace app\api\controller;

use app\api\BaseController;
use think\exception\ValidateException;
use app\admin\model\Wxapp as WxappModel;
use think\facade\Db;
/**
 * 配置信息
 */
class Wxapp extends BaseController
{
	
	protected function initialize(){

		$uniacid = $this->request->header('uniacid');
		$where = [];
		$where['id']=$uniacid;
			
		$field = '*';

		$wxapp = WxappModel::where(formatWhere($where))->field($field)->find();
		if ($wxapp) {
			$this->request->uniacid=$uniacid;

		}else{
			
			throw new ValidateException("程序不存在，id=" . $uniacid);

		}
		
		
	}
}