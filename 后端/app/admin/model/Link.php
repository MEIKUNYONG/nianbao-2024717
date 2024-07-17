<?php 
/*
 module:		友情链接控制器
 create_time:	2022-08-19 17:08:28
 author:		
 contact:		
*/

namespace app\admin\model;
use think\Model;

class Link extends Model {


	protected $connection = 'mysql';

 	protected $pk = 'link_id';

 	protected $name = 'link';


	function linkcata(){
		return $this->hasOne(\app\admin\model\Linkcata::class,'linkcata_id','linkcata_id');
	}



}

