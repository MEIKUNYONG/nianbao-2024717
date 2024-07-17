<?php 
/*
 module:		商品分类控制器
 create_time:	2022-07-11 16:28:25
 author:		
 contact:		
*/

namespace app\admin\model;
use think\Model;

class Goodscata extends Model {


	protected $connection = 'mysql';

 	protected $pk = 'class_id';

 	protected $name = 'goods_cata';


	function supplier(){
		return $this->hasOne(\app\admin\model\Supplier::class,'supplier_id','supplier_id');
	}



}

