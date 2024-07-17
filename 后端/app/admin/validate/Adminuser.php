<?php 
/*
 module:		用户管理控制器
 create_time:	2022-08-19 16:12:11
 author:		
 contact:		
*/

namespace app\admin\validate;
use think\validate;

class Adminuser extends validate {


	protected $rule = [
		'user'=>['require'],
		'pwd'=>['require'],
		'name'=>['require'],
	];

	protected $message = [
		'user.require'=>'用户名不能为空',
		'pwd.require'=>'密码不能为空',
		'name.require'=>'所属分组不能为空',
	];

	protected $scene  = [
		'add'=>['name','user','pwd'],
		'update'=>['name','user'],
	];



}

