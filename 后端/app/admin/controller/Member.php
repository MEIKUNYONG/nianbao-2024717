<?php 

namespace app\admin\controller;
use think\facade\Db;
use app\admin\model\Member as MemberModel;
use app\lk\controller\BaseUser;
use think\exception\ValidateException;
use app\admin\model\Enterprise as EnterpriseModel;
use app\admin\model\EnterpriseReport;

use app\admin\model\MemberEnterprise;
class Member extends Admin {


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
		
			$where['nickname'] = $this->request->post('nickname', '', 'serach_in');
		
			
			$create_time = $this->request->post('create_time', '', 'serach_in');
			$where['create_time'] = ['between',[strtotime($create_time[0]),strtotime($create_time[1])]];
		
			$field = 'id,nickname,openid,avatar,mobile,is_delete,create_time';

			$order  = $this->request->post('order', '', 'serach_in');	//排序字段
			$sort  = $this->request->post('sort', '', 'serach_in');		//排序方式

			$orderby = ($sort && $order) ? $sort.' '.$order : 'id desc';

			$res =  MemberModel::where(formatWhere($where))->field($field)->order($orderby)->paginate(['list_rows'=>$limit,'page'=>$page])->toArray();

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
		 MemberModel::update($data);
		return json(['status'=>200,'msg'=>'操作成功']);
	}


	/*
 	* @Description  修改信息之前查询信息的 勿要删除
 	*/
	function getUpdateInfo(){
		$id =  $this->request->post('id', '', 'serach_in');
		if(!$id) throw new ValidateException ('参数错误');
		$field = 'id,username,sex,pic,mobile,email,amount,status,ssq,create_time';
		$res =  MemberModel::field($field)->find($id);
		$res['ssq'] = explode('-',$res['ssq']);
		return json(['status'=>200,'data'=>$res]);
	}


	/*
 	* @Description  删除
 	*/
	function delete(){
		$idx =  $this->request->post('id', '', 'serach_in');
		if(!$idx) throw new ValidateException ('参数错误');
		 MemberModel::destroy(['id'=>explode(',',$idx)],true);
		return json(['status'=>200,'msg'=>'操作成功']);
	}


	/*
 	* @Description  查看详情
 	*/
	function detail(){
		$id =  $this->request->post('member_id', '', 'serach_in');
		if(!$id) throw new ValidateException ('参数错误');
		$field = 'id,username,sex,pic,mobile,email,amount,status,ssq,create_time';
		$res =  MemberModel::field($field)->find($id);
		return json(['status'=>200,'data'=>$res]);
	}




	/*
 	* @Description  禁用
 	*/
	public function forbidden(){
		$idx = $this->request->post('id', '', 'serach_in');
		if(empty($idx)) throw new ValidateException ('参数错误');

		$data['status'] = 0;
		$res = MemberModel::where(['id'=>explode(',',$idx)])->update($data);
		return json(['status'=>200,'msg'=>'操作成功']);
	}


	/*
 	* @Description  启用
 	*/
	public function start(){
		$idx = $this->request->post('id', '', 'serach_in');
		if(empty($idx)) throw new ValidateException ('参数错误');

		$data['status'] = 1;
		$res = MemberModel::where(['id'=>explode(',',$idx)])->update($data);
		return json(['status'=>200,'msg'=>'操作成功']);
	}
	
	public function binding(){
	    if (!$this->request->isPost()){
			return view('binding');
		}else{
		    $limit  = $this->request->post('limit', 20, 'intval');
			$page = $this->request->post('page', 1, 'intval');
			$member_id=$this->request->post('id', '', 'serach_in');
		
			$wheres = [];
            $wheres['id']=$member_id;
    
            $Member = MemberModel::where(formatWhere($wheres))->find();
            $mobile=$Member->mobile;
            
            $whe = [];
            $whe['member_mobile']=$mobile;
    
            $MemberEnterprise = MemberEnterprise::where(formatWhere($whe))->order('id desc')->field($field)->order($orderby)->paginate(['list_rows'=>$limit,'page'=>$page])->toArray();
            $arr=[];
            foreach ($MemberEnterprise['data'] as $k=>$v){
                $str=[];
                
                $enterprise_id=$v['enterprise_id'];
                
                $where = [];
                $where['id']=$enterprise_id;
                
                $enterprise = EnterpriseModel::where(formatWhere($where))->find();
                
                $cha = [];
			    $cha['enterprise_code'] = $enterprise->enterprise_code;
			    
			    $enterpriseReport = EnterpriseReport::where(formatWhere($cha))->find();
			    
			    
			    $str['enterprise_name']=$enterprise->enterprise_name;
			    $str['enterprise_code']=$enterprise->enterprise_code;
			    $str['report_year']=$enterpriseReport->report_year;
			    $str['is_report']=$enterpriseReport->is_report;
			    $arr[]=$str;
			    
                
            }
            $MemberEnterprise['data']=$arr;
            
            $data['status'] = 200;
			$data['data'] = $MemberEnterprise;
			return json($data);

            
			
		}
	}




}

