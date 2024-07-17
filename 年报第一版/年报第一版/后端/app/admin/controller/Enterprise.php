<?php 

namespace app\admin\controller;
use think\exception\ValidateException;
use app\admin\model\Enterprise as EnterpriseModel;
use think\facade\Db;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use app\admin\model\EnterpriseReport;
use app\admin\model\Baseconfig as BaseconfigModel;
class Enterprise extends Admin {


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
			$where['enterprise_name'] = $this->request->post('enterprise_name', '', 'serach_in');
		
			$where['mobile'] = $this->request->post('mobile', '', 'serach_in');

			//$where['ub.is_report'] = $this->request->post('is_report', '', 'serach_in');
			
			/*$lastYear = date('Y', strtotime('-1 year'));
			$where['ub.report_year'] =$lastYear;*/
		

			$field = '*';
			
		

			$order  = $this->request->post('order', '', 'serach_in');	//排序字段
			$sort  = $this->request->post('sort', '', 'serach_in');		//排序方式

			$orderby = ($sort && $order) ? $sort.' '.$order : 'id desc';
			
			//$res = EnterpriseModel::alias('u')->join("enterprise_report ub", 'u.enterprise_code=ub.enterprise_code', 'left')->where(formatWhere($where))->field($field)->order($orderby)->paginate(['list_rows'=>$limit,'page'=>$page])->toArray();

			$res = EnterpriseModel::where(formatWhere($where))->where('status','<>',3)->field($field)->order($orderby)->paginate(['list_rows'=>$limit,'page'=>$page])->toArray();

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
		EnterpriseModel::update($data);
		return json(['status'=>200,'msg'=>'操作成功']);
	}

	/*
 	* @Description  添加
 	*/
	public function add(){
		$postField = 'enterprise_name,enterprise_code,mobile,legal_person,status,is_special';
		$data = $this->request->only(explode(',',$postField),'post',null);


		try{
		    $enterprise_code=$data['enterprise_code'];
		    $where = [];
            $where['enterprise_code']=$enterprise_code;
            $enterprise = EnterpriseModel::where(formatWhere($where))->find();
            if (!$enterprise) {
                $res = EnterpriseModel::insertGetId($data);
                
                $lastYear = date('Y', strtotime('-1 year'));
                $whe = [];
                   
                $whe['enterprise_code']=$enterprise_code;
                $whe['report_year']=$lastYear;
                $report = EnterpriseReport::where(formatWhere($whe))->find();
                
                if (!$report) {
                        // 获取去年的年份
                        
                    $enterpriseReport=new EnterpriseReport;
                    $enterpriseReport->enterprise_code=$enterprise_code;
                    $enterpriseReport->report_year=$lastYear;
                    $enterpriseReport->is_report=0;
                    $enterpriseReport->save();
                     
                }
            }else{
                throw new ValidateException ('企业已存在，请勿重新添加');
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
		$postField = 'id,enterprise_name,enterprise_code,mobile,legal_person,status,is_special';
		$data = $this->request->only(explode(',',$postField),'post',null);


		try{
			EnterpriseModel::update($data);
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
		$res = EnterpriseModel::field($field)->find($id);

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
		    $data['status'] = 3;

		    $res=EnterpriseModel::where(['id'=>$v])->update($data);
		    
		}
		return json(['status'=>200,'msg'=>'操作成功']);
		
		
	}


	/*
 	* @Description  导入
 	*/
	public function importData(){
		$data = $this->request->post();
		$list = [];
		$arr=[];
		foreach($data as $key=>$val){
		    $enterprise_code=$val['统一社会信用代码'];
		    $where = [];
            $where['enterprise_code']=$enterprise_code;
            $enterprise = EnterpriseModel::where(formatWhere($where))->find();
            if (!$enterprise) {
                $list[$key]['enterprise_name'] = $val['企业名称'];
    			$list[$key]['enterprise_code'] = $val['统一社会信用代码'];
    			$list[$key]['legal_person'] = $val['法定代表人'];
    			$list[$key]['mobile'] = $val['手机号'];
    			$list[$key]['status'] = 1;
    			$list[$key]['is_special'] =1;
    			
    			
    			$lastYear = date('Y', strtotime('-1 year'));
                $whe = [];
                   
                $whe['enterprise_code']=$enterprise_code;
                $whe['report_year']=$lastYear;
                $report = EnterpriseReport::where(formatWhere($whe))->find();
                
                if (!$report) {
                        // 获取去年的年份
                        
                    $enterpriseReport=new EnterpriseReport;
                    $enterpriseReport->enterprise_code=$enterprise_code;
                    $enterpriseReport->report_year=$lastYear;
                    $enterpriseReport->is_report=0;
                    $enterpriseReport->save();
                     
                }
    			
    			
            }
		    
			
			
			
			
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
	
	//发送短信
	public function send()
    {
        //查找数据库一键发送未年报提醒短信
        //循环遍历年报表查找出未年报的企业code根据企业代码去企业表里查询对应的电话，然后触发发送短信提醒
        $whe = [];
        $lastYear = date('Y', strtotime('-1 year'));

        $whe['report_year']=$lastYear;
        $whe['is_report']=0;
        $report = EnterpriseReport::where(formatWhere($whe))->select();
       
        $config = BaseconfigModel::column('data','name');
        
        if(!$config['hy_type']){
            throw new ValidateException ('请配置短信设置后重试');
        }
        if ($config['hy_type']==1) {
            $hy_apiid=$config['hy_apiid'];
            $hy_apikey=$config['hy_apikey'];
            if(!$hy_apiid || !$hy_apikey){
                throw new ValidateException ('请配置短信设置后重试');
            }
            // code...
        }
        
        $arr=[];
        foreach ($report as $k=>$v){
            $str=[];
            $enterprise_code=$v['enterprise_code'];
            
            $where = [];
            $where['enterprise_code']=$enterprise_code;
          
            $enterprise = EnterpriseModel::where(formatWhere($where))->find();
            
            $enterprise_name=$enterprise->enterprise_name;
            
            $mobile=$enterprise->mobile;
            
            //发送短信
            $str['mobile']=$mobile;
            $arr[]=$str;
          
        }
        $mobiles = implode(',', array_map(function($a) {

            return implode(',', $a);
        
        }, $arr));
     
        if ($config['hy_type']==1) {
            $target = "http://api.yx.ihuyi.com/webservice/sms.php?method=Submit";
                
            //$mobiles = '18713793568';//手机号码，多个号码请用,隔开
            $account=$hy_apiid;
            $password=$hy_apikey;
                
            $nei="尊敬的用户您好，您的企业还未提审，请点击 28182.cn/aBJN3X 快速提交。退订回T【领客年报通】";
            $post_data = "account=$account&password=$password&mobile=".$mobiles."&content=".rawurlencode($nei);
                //用户名是登录用户中心->营销短信->产品总览->APIID
                //查看密码请登录用户中心->营销短信->产品总览->APIKEY
             $gets = $this->xml_to_array($this->getPost($post_data, $target));
            
            if($gets['SubmitResult']['code']==2){
                return json(['status'=>200,'msg'=>$gets['SubmitResult']['msg']]);
            }else{
                return json(['status'=>201,'msg'=>$gets['SubmitResult']['msg']]);
            }
        }
     
        
        
    }
    
    public function getPost($curlPost,$url){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_NOBODY, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
		$return_str = curl_exec($curl);
		curl_close($curl);
		return $return_str;
    }
    public function xml_to_array($xml){
    	$reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
    	if(preg_match_all($reg, $xml, $matches)){
    		$count = count($matches[0]);
    		for($i = 0; $i < $count; $i++){
    		$subxml= $matches[2][$i];
    		$key = $matches[1][$i];
    			if(preg_match( $reg, $subxml )){
    				$arr[$key] = $this->xml_to_array( $subxml );
    			}else{
    				$arr[$key] = $subxml;
    			}
    		}
    	}
    	return $arr;
    }





}

