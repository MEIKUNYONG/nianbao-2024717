<?php 

namespace app\admin\controller;
use think\exception\ValidateException;
use app\admin\model\Order as OrderModel;
use think\facade\Db;
use app\admin\model\Remarks as RemarksModel;

class Remarks extends Admin {


	/*
 	* @Description  数据列表
 	*/
	function index(){
		if (!$this->request->isPost()){
			return view('index');
		}else{
			$limit  = $this->request->post('limit', 20, 'intval');
			$page = $this->request->post('page', 1, 'intval');
			$order_id=$this->request->post('order_id', '', 'serach_in');
			
		
			
			
			$where = [];
			$where['u.order_id'] = $order_id;
			
			$where['u.is_delete'] = 0;
			

			//$where['ub.is_report'] = $this->request->post('is_report', '', 'serach_in');
			
			/*$lastYear = date('Y', strtotime('-1 year'));
			$where['ub.report_year'] =$lastYear;*/
		

			$field = 'u.*,ad.user_id,ad.name';
			
		

			$order  = $this->request->post('order', '', 'serach_in');	//排序字段
			$sort  = $this->request->post('sort', '', 'serach_in');		//排序方式

			$orderby = ($sort && $order) ? $sort.' '.$order : 'u.id desc';
			
			$res = RemarksModel::alias('u')->join("order ub", 'u.order_id=ub.id', 'left')->join("admin_user ad", 'u.admin_id=ad.user_id', 'left')->where(formatWhere($where))->field($field)->order($orderby)->paginate(['list_rows'=>$limit,'page'=>$page])->toArray();

			//$res = RemarksModel::where(formatWhere($where))->field($field)->order($orderby)->paginate(['list_rows'=>$limit,'page'=>$page])->toArray();
			$admin = session('admin');
		    $admin_id=$admin['user_id'];

			$data['status'] = 200;
			$data['data'] = $res;
			$data['data']['admin_id'] = $admin_id;
			return json($data);
		}
	}


	/*
 	* @Description  修改排序开关
 	*/
	function updateExt(){
		$postField = 'id,status';
		$data = $this->request->only(explode(',',$postField),'post',null);
		if(!$data['membe_id']) throw new ValidateException ('参数错误');
		RemarksModel::update($data);
		return json(['status'=>200,'msg'=>'操作成功']);
	}

	/*
 	* @Description  添加
 	*/
	public function add(){
		$postField = 'remarks_content,remarks_people,order_id';
		$data = $this->request->only(explode(',',$postField),'post',null);
        $data['create_time']=time();
        $data['update_time']=time();
        $admin = session('admin');
		$admin_id=$admin['user_id'];
		$data['admin_id']=$admin_id;
		try{
			$res = RemarksModel::insertGetId($data);
		}catch(\Exception $e){
			throw new ValidateException($e->getMessage());
		}
		return json(['status'=>200,'data'=>$res,'msg'=>'添加成功']);
	}


	/*
 	* @Description  修改
 	*/
	public function update(){
		$postField = 'id,remarks_content,remarks_people';
		$data = $this->request->only(explode(',',$postField),'post',null);

        $data['update_time']=time();
		try{
			RemarksModel::update($data);
		}catch(\Exception $e){
			throw new ValidateException($e->getMessage());
		}
		return json(['status'=>200,'msg'=>'修改成功']);
	}


	/*
 	* @Description  修改信息之前查询信息的 勿要删除
 	*/
	function getUpdateInfo(){
		$id =  $this->request->post('id', '', 'serach_in');
		if(!$id) throw new ValidateException ('参数错误');
		$field = 'id,remarks_content,remarks_people,order_id';
		$res = RemarksModel::field($field)->find($id);

		return json(['status'=>200,'data'=>$res]);
	}


	/*
 	* @Description  删除
 	*/
	function delete(){
		$idx =  $this->request->post('id', '', 'serach_in');
		if(!$idx) throw new ValidateException ('参数错误');
		 $ids=explode(',',$idx);
		
		foreach ($ids as $k=>$v){
		   $data=[];
		   $data['id']=$v;
    	   $data['is_delete']=1;
    	   $data['delete_time']=time();
    	   $ss=RemarksModel::update($data);
		}
		
		return json(['status'=>200,'msg'=>'操作成功']);
	}







}

