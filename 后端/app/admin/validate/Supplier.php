<?php 
/*
 module:		供应商管理控制器
 create_time:	2022-07-11 16:28:27
 author:		
 contact:		
*/

namespace app\admin\validate;
use think\validate;

class Supplier extends validate {


	protected $rule = [
		'supplier_name'=>['require'],
	];

	protected $message = [
		'supplier_name.require'=>'供应商名称不能为空',
	];

	protected $scene  = [
		'add'=>['supplier_name'],
		'update'=>['supplier_name'],
	];



}

