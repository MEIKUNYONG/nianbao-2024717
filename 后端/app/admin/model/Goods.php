<?php 
/*
 module:		商品管理控制器
 create_time:	2022-07-15 11:43:09
 author:		
 contact:		
*/

namespace app\admin\model;
use think\Model;

class Goods extends Model {


	protected $connection = 'mysql';

 	protected $pk = 'goods_id';

 	protected $name = 'goods';


	function goodscata(){
		return $this->hasOne(\app\admin\model\Goodscata::class,'class_id','class_id');
	}

	function supplier(){
		return $this->hasOne(\app\admin\model\Supplier::class,'supplier_id','supplier_id');
	}



}

