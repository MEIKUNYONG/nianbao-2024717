<?php 


namespace app\admin\controller;
use think\exception\ValidateException;
use app\admin\model\Area as AreaModel;
use think\facade\Db;

class Area extends Admin {


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
			//$where['class_name'] = $this->request->post('class_name', '', 'serach_in');
			$where['status'] = $this->request->post('status', '', 'serach_in');

			$field = '*';

			$order  = $this->request->post('order', '', 'serach_in');	//排序字段
			$sort  = $this->request->post('sort', '', 'serach_in');		//排序方式

			$orderby = ($sort && $order) ? $sort.' '.$order : 'id desc';

			$res = AreaModel::where(formatWhere($where))->field($field)->order($orderby)->paginate(['list_rows'=>$limit,'page'=>$page])->toArray();

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
		if(!$data['id']) throw new ValidateException ('参数错误');
		AreaModel::update($data);
		return json(['status'=>200,'msg'=>'操作成功']);
	}

	/*
 	* @Description  添加
 	*/
	public function add(){
		$postField = 'ssq,area_price,status';
		$data = $this->request->only(explode(',',$postField),'post',null);
		
		$datas=[];
        
        $datas['area_sheng'] = $data['ssq'][0];
        $datas['area_shi'] = $data['ssq'][1];
        $datas['area_qu'] = $data['ssq'][2];
        $where = [];
        $where['area_sheng']=$datas['area_sheng'];
        $where['area_shi']=$datas['area_shi'];
        $where['area_qu']=$datas['area_qu'];
            
        $Area = AreaModel::where(formatWhere($where))->find();
        if ($Area) {
            throw new ValidateException ('已存在此地区');
        }
        
        
        $datas['area_price'] = $data['area_price'];

		try{
			$res = AreaModel::insertGetId($datas);
		}catch(\Exception $e){
			throw new ValidateException($e->getMessage());
		}
		return json(['status'=>200,'data'=>$res,'msg'=>'添加成功']);
	}


	/*
 	* @Description  修改
 	*/
	public function update(){
		$postField = 'id,ssq,area_price,status';
		$data = $this->request->only(explode(',',$postField),'post',null);

		$datas=[];
        $datas['id'] = $data['id'];
        $datas['area_sheng'] = $data['ssq'][0];
        $datas['area_shi'] = $data['ssq'][1];
        $datas['area_qu'] = $data['ssq'][2];
        
        $datas['area_price'] = $data['area_price'];
		try{
			AreaModel::update($datas);
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
		$field = 'id,area_sheng,area_shi,area_qu,area_price,status';
		$res = AreaModel::field($field)->find($id);
		$res['ssq'] = [$res['area_sheng'],$res['area_shi'],$res['area_qu']];
		return json(['status'=>200,'data'=>$res]);
	}


	/*
 	* @Description  删除
 	*/
	function delete(){
		$idx =  $this->request->post('id', '', 'serach_in');
		if(!$idx) throw new ValidateException ('参数错误');
		AreaModel::destroy(['id'=>explode(',',$idx)],true);
		return json(['status'=>200,'msg'=>'操作成功']);
	}


	/*
 	* @Description  查看详情
 	*/
	function detail(){
		$id =  $this->request->post('id', '', 'serach_in');
		if(!$id) throw new ValidateException ('参数错误');
		$field = 'id,area_sheng,status';
		$res = AreaModel::field($field)->find($id);
		return json(['status'=>200,'data'=>$res]);
	}




}

