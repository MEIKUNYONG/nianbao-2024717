<?php 
/*
 module:		节点管理控制器
 create_time:	2022-08-19 17:20:31
 author:		
 contact:		
*/

namespace app\admin\model;
use think\Model;

class Node extends Model {


	protected $connection = 'mysql';

 	protected $pk = 'node_id';

 	protected $name = 'node';




}

