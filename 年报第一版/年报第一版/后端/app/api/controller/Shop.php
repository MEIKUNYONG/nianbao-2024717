<?php 

declare (strict_types = 1);

namespace app\api\controller;

use think\exception\ValidateException;

use think\facade\Db;
use app\api\middleware\ApiMiddleware;
use app\api\BaseController;
use app\admin\model\Shop as ShopModel;
use app\admin\model\Shoptype as ShoptypeModel;
use app\admin\model\Baseconfig as BaseconfigModel;
use think\facade\Log;


class Shop extends BaseController
{
    public function get_typelist() 
	{
		
		    $where = [];
			
			$where['status'] =1;
			$field = 'id,class_name';

			$orderby ='sortid asc';

			$res = ShoptypeModel::where(formatWhere($where))->field($field)->order($orderby)->select()->toArray();
			
			return json(['code' => 200, 'msg' => '获取成功', 'data' => $res]);

	}
	
	public function get_shoplist() 
	{
	   $data= $this->request->param();
       $class_id=$data['class_id'];
       
       $where = [];
			
	   $where['class_id'] =$class_id;
	   
	   $field = 'id,class_id,goods_name,pic,sale_price,sortid,create_time,subtitle';
	   $orderby ='sortid asc';
	   $shop = ShopModel::where(formatWhere($where))->field($field)->order($orderby)->select();
	   foreach ($shop as $k=>$v){
	       $shop[$k]['sale_price']=floatval($v['sale_price']);
	   }
	   
	   return json(['code' => 200, 'msg' => '获取成功', 'data' => $shop]);
	}
	
	public function config() 
	{
	    
	}
	
	
}