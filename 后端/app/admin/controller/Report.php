<?php 

namespace app\admin\controller;
use think\exception\ValidateException;
use app\admin\model\Enterprise as EnterpriseModel;
use think\facade\Db;
use app\admin\model\EnterpriseReport;

class Report extends Admin {


	/*
 	* @Description  数据列表
 	*/
	function index(){
		if (!$this->request->isPost()){
			return view('index');
		}else{
			$limit  = $this->request->post('limit', 20, 'intval');
			$page = $this->request->post('page', 1, 'intval');
			$enterprise_id=$this->request->post('id', '', 'serach_in');
			
			
			$wheres = [];
            $wheres['id']=$enterprise_id;
          
            $enterprise = EnterpriseModel::where(formatWhere($wheres))->find();

			$where = [];
			$where['u.enterprise_code'] = $enterprise->enterprise_code;
			

			//$where['ub.is_report'] = $this->request->post('is_report', '', 'serach_in');
			
			/*$lastYear = date('Y', strtotime('-1 year'));
			$where['ub.report_year'] =$lastYear;*/
		

			$field = 'u.*,ub.enterprise_name';
			
		

			$order  = $this->request->post('order', '', 'serach_in');	//排序字段
			$sort  = $this->request->post('sort', '', 'serach_in');		//排序方式

			$orderby = ($sort && $order) ? $sort.' '.$order : 'id desc';
			
			$res = EnterpriseReport::alias('u')->join("enterprise ub", 'u.enterprise_code=ub.enterprise_code', 'left')->where(formatWhere($where))->field($field)->order($orderby)->paginate(['list_rows'=>$limit,'page'=>$page])->toArray();

			//$res = EnterpriseReport::where(formatWhere($where))->field($field)->order($orderby)->paginate(['list_rows'=>$limit,'page'=>$page])->toArray();

			$data['status'] = 200;
			$data['data'] = $res;
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
		EnterpriseReport::update($data);
		return json(['status'=>200,'msg'=>'操作成功']);
	}

	/*
 	* @Description  添加
 	*/
	public function add(){
		$postField = 'enterprise_name,enterprise_code,mobile,legal_person,status,is_special';
		$data = $this->request->only(explode(',',$postField),'post',null);


		try{
			$res = EnterpriseReport::insertGetId($data);
		}catch(\Exception $e){
			throw new ValidateException($e->getMessage());
		}
		return json(['status'=>200,'data'=>$res,'msg'=>'添加成功']);
	}


	/*
 	* @Description  修改
 	*/
	public function update(){
		$postField = 'id,enterprise_name,enterprise_code,mobile,legal_person,status,is_special';
		$data = $this->request->only(explode(',',$postField),'post',null);


		try{
			EnterpriseReport::update($data);
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
		$field = 'id,enterprise_name,enterprise_code,mobile,legal_person,status,is_special';
		$res = EnterpriseReport::field($field)->find($id);

		return json(['status'=>200,'data'=>$res]);
	}


	/*
 	* @Description  删除
 	*/
	function delete(){
		$idx =  $this->request->post('id', '', 'serach_in');
		if(!$idx) throw new ValidateException ('参数错误');
		EnterpriseReport::destroy(['id'=>explode(',',$idx)],true);
		return json(['status'=>200,'msg'=>'操作成功']);
	}


	/*
 	* @Description  导入
 	*/
	public function importData(){
		$data = $this->request->post();
		$list = [];
		foreach($data as $key=>$val){
			$list[$key]['enterprise_name'] = $val['企业名称'];
			$list[$key]['enterprise_code'] = $val['统一社会信用代码'];
			$list[$key]['legal_person'] = $val['法定代表人'];
			$list[$key]['mobile'] = $val['电话'];
			$list[$key]['status'] = 1;
			$list[$key]['is_special'] =1;
		}
		(new EnterpriseModel)->insertAll($list);
		return json(['status'=>200]);
	}


	/*
 	* @Description  禁用
 	*/
	public function forbidden(){
		$idx = $this->request->post('id', '', 'serach_in');
		if(empty($idx)) throw new ValidateException ('参数错误');

		$data['status'] = 0;
		$res = EnterpriseModel::where(['id'=>explode(',',$idx)])->update($data);
		return json(['status'=>200,'msg'=>'操作成功']);
	}


	/*
 	* @Description  启用
 	*/
	public function start(){
		$idx = $this->request->post('id', '', 'serach_in');
		if(empty($idx)) throw new ValidateException ('参数错误');

		$data['status'] = 1;
		$res = EnterpriseModel::where(['id'=>explode(',',$idx)])->update($data);
		return json(['status'=>200,'msg'=>'操作成功']);
	}




}

