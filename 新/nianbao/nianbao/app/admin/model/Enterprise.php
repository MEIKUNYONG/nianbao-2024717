<?php 


namespace app\admin\model;
use think\Model;

class Enterprise extends Model {


	protected $connection = 'mysql';

 	protected $pk = 'id';

 	protected $name = 'enterprise';
 	
 	function enterprise_report(){
		return $this->hasOne(\app\admin\model\EnterpriseReport::class,'id','enterprise_id');
	}




}

