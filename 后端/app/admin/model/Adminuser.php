<?php 
/*
 module:		用户管理控制器
 create_time:	2022-08-19 16:12:11
 author:		
 contact:		
*/

namespace app\admin\model;
use think\Model;

class Adminuser extends Model {


	protected $connection = 'mysql';

 	protected $pk = 'user_id';

 	protected $name = 'admin_user';


	function role(){
		return $this->hasOne(\app\admin\model\Role::class,'role_id','role_id');
	}



}

