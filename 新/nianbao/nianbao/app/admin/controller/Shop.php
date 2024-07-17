<?php 


namespace app\admin\controller;
use think\exception\ValidateException;
use app\admin\model\Shop as ShopModel;
use think\facade\Db;

class Shop extends Admin {


	/*
 	* @Description  数据列表
 	*/
	function index(){
		if (!$this->request->isPost()){
			return view('index');
		}else{
			$limit  = $this->request->post('limit', 20, 'intval');
			$page = $this->request->post('page', 1, 'intval');

			$where = [];
			$where['id'] = $this->request->post('id', '', 'serach_in');
			$where['shop.class_id'] = $this->request->post('class_id', '', 'serach_in');
			$where['shop.status'] = $this->request->post('status', '', 'serach_in');

			$field = 'id,goods_name,pic,sale_price,status,sortid,create_time';

			$withJoin = [
				'shoptype'=>explode(',','class_name'),
			];

			$order  = $this->request->post('order', '', 'serach_in');	//排序字段
			$sort  = $this->request->post('sort', '', 'serach_in');		//排序方式

			$orderby = ($sort && $order) ? $sort.' '.$order : 'id desc';

			$res = ShopModel::where(formatWhere($where))->field($field)->withJoin($withJoin,'left')->order($orderby)->paginate(['list_rows'=>$limit,'page'=>$page])->toArray();

			$data['status'] = 200;
			$data['data'] = $res;
			$page == 1 && $data['sql_field_data'] = $this->getSqlField('id');
			return json($data);
		}
	}




	/*
 	* @Description  修改排序开关
 	*/
	function updateExt(){
		$postField = 'id,status,sortid';
		$data = $this->request->only(explode(',',$postField),'post',null);
		if(!$data['id']) throw new ValidateException ('参数错误');
		ShopModel::update($data);
		return json(['status'=>200,'msg'=>'操作成功']);
	}

	/*
 	* @Description  添加
 	*/
	public function add(){
		$postField = 'goods_name,class_id,pic,sale_price,status,sortid,create_time,detail,subtitle';
		$data = $this->request->only(explode(',',$postField),'post',null);

		$data['create_time'] = time();

		try{
			$res = ShopModel::insertGetId($data);
			if($res && empty($data['sortid'])){
				 ShopModel::update(['sortid'=>$res,'id'=>$res]);
			}
		}catch(\Exception $e){
			throw new ValidateException($e->getMessage());
		}
		return json(['status'=>200,'data'=>$res,'msg'=>'添加成功']);
	}


	/*
 	* @Description  修改
 	*/
	public function update(){
		$postField = 'id,goods_name,class_id,pic,sale_price,status,sortid,create_time,detail,subtitle';
		$data = $this->request->only(explode(',',$postField),'post',null);

		if(!isset($data['class_id'])){
			$data['class_id'] = null;
		}
	
		$data['create_time'] = strtotime($data['create_time']);
	

		try{
			ShopModel::update($data);
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
		$field = 'id,goods_name,class_id,pic,sale_price,status,sortid,create_time,detail,subtitle';
		$res = ShopModel::field($field)->find($id);
	
		return json(['status'=>200,'data'=>$res]);
	}


	/*
 	* @Description  删除
 	*/
	function delete(){
		$idx =  $this->request->post('id', '', 'serach_in');
		if(!$idx) throw new ValidateException ('参数错误');
		ShopModel::destroy(['id'=>explode(',',$idx)],true);
		return json(['status'=>200,'msg'=>'操作成功']);
	}


	/*
 	* @Description  查看详情
 	*/
	function detail(){
		$id =  $this->request->post('id', '', 'serach_in');
		if(!$id) throw new ValidateException ('参数错误');
		$withJoin = [
			
			'shoptype'=>explode(',','class_name'),
		];

		$field = 'id,goods_name,pic,sale_price,status,sortid,create_time,subtitle';
		$res = ShopModel::field($field)->withJoin($withJoin,'left')->find($id);
		return json(['status'=>200,'data'=>$res]);
	}


	/*
 	* @Description  获取定义sql语句的字段信息
 	*/
	function getFieldList(){
		return json(['status'=>200,'data'=>$this->getSqlField('id')]);
	}

	/*
 	* @Description  获取定义sql语句的字段信息
 	*/
	private function getSqlField($list){
		$data = [];
		if(in_array('id',explode(',',$list))){
			$data['id'] = $this->query('select id,class_name from pre_shop_type','mysql');
		}
		return $data;
	}


}

