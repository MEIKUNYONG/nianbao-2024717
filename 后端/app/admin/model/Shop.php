<?php 

namespace app\admin\model;
use think\Model;

class Shop extends Model {


	protected $connection = 'mysql';

 	protected $pk = 'id';

 	protected $name = 'shop';


	function shoptype(){
		return $this->hasOne(\app\admin\model\Shoptype::class,'id','class_id');
	}





}

