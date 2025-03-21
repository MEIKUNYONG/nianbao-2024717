<?php 
/*
 module:		节点管理控制器
 create_time:	2022-08-19 17:20:31
 author:		
 contact:		
*/

namespace app\admin\controller;
use think\exception\ValidateException;
use app\admin\model\Node as NodeModel;
use think\facade\Db;

class Node extends Admin {


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
			$where['node_id'] = $this->request->post('node_id', '', 'serach_in');

			$field = 'node_id,title,type,path,status,icon,sortid,pid';

			$order  = $this->request->post('order', '', 'serach_in');	//排序字段
			$sort  = $this->request->post('sort', '', 'serach_in');		//排序方式

			$orderby = ($sort && $order) ? $sort.' '.$order : 'sortid asc';

			$res = NodeModel::where(formatWhere($where))->field($field)->order($orderby)->paginate(['list_rows'=>$limit,'page'=>$page])->toArray();

			$res['data'] = _generateListTree($res['data'],0,['node_id','pid']);

			$data['status'] = 200;
			$data['data'] = $res;
			$page == 1 && $data['sql_field_data'] = $this->getSqlField('pid');
			return json($data);
		}
	}


	/*
 	* @Description  修改排序开关
 	*/
	function updateExt(){
		$postField = 'node_id,status,sortid';
		$data = $this->request->only(explode(',',$postField),'post',null);
		if(!$data['node_id']) throw new ValidateException ('参数错误');
		NodeModel::update($data);
		return json(['status'=>200,'msg'=>'操作成功']);
	}

	/*
 	* @Description  添加
 	*/
	public function add(){
		$postField = 'pid,title,type,path,status,icon,sortid';
		$data = $this->request->only(explode(',',$postField),'post',null);

		$this->validate($data,\app\admin\validate\Node::class);

		try{
			$res = NodeModel::insertGetId($data);
			if($res && empty($data['sortid'])){
				NodeModel::update(['sortid'=>$res,'node_id'=>$res]);
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
		$postField = 'node_id,pid,title,type,path,status,icon,sortid';
		$data = $this->request->only(explode(',',$postField),'post',null);

		$this->validate($data,\app\admin\validate\Node::class);


		if(!isset($data['pid'])){
			$data['pid'] = null;
		}

		try{
			NodeModel::update($data);
		}catch(\Exception $e){
			throw new ValidateException($e->getMessage());
		}
		return json(['status'=>200,'msg'=>'修改成功']);
	}


	/*
 	* @Description  修改信息之前查询信息的 勿要删除
 	*/
	function getUpdateInfo(){
		$id =  $this->request->post('node_id', '', 'serach_in');
		if(!$id) throw new ValidateException ('参数错误');
		$field = 'node_id,pid,title,type,path,status,icon,sortid';
		$res = NodeModel::field($field)->find($id);
		return json(['status'=>200,'data'=>$res]);
	}


	/*
 	* @Description  删除
 	*/
	function delete(){
		$idx =  $this->request->post('node_id', '', 'serach_in');
		if(!$idx) throw new ValidateException ('参数错误');
		NodeModel::destroy(['node_id'=>explode(',',$idx)],true);
		return json(['status'=>200,'msg'=>'操作成功']);
	}


	/*
 	* @Description  查看详情
 	*/
	function detail(){
		$id =  $this->request->post('node_id', '', 'serach_in');
		if(!$id) throw new ValidateException ('参数错误');
		$field = 'node_id,title,type,path,status,icon,sortid';
		$res = NodeModel::field($field)->find($id);
		return json(['status'=>200,'data'=>$res]);
	}


	/*
 	* @Description  获取定义sql语句的字段信息
 	*/
	function getFieldList(){
		return json(['status'=>200,'data'=>$this->getSqlField('pid')]);
	}

	/*
 	* @Description  获取定义sql语句的字段信息
 	*/
	private function getSqlField($list){
		$data = [];
		if(in_array('pid',explode(',',$list))){
			$data['pids'] = _generateSelectTree($this->query('select node_id,title,pid from pre_node order by sortid asc','mysql'));
		}
		return $data;
	}



}

