<?php 


namespace app\admin\controller;
use think\exception\ValidateException;
use app\admin\model\Order as OrderModel;
use think\facade\Db;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use EasyWeChat\Factory;
use app\admin\model\Baseconfig as BaseconfigModel;
use app\admin\model\Enterprise as EnterpriseModel;
use think\facade\Log;
use app\api\middleware\AopClient;
use app\admin\model\EnterpriseReport;
use app\admin\model\Pay as PayModel;
class Order extends Admin {


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
			$where['order_no'] = $this->request->post('order_no', '', 'serach_in');
		
			$where['mobile'] = $this->request->post('mobile', '', 'serach_in');
			$where['fmobile'] = $this->request->post('fmobile', '', 'serach_in');
			$where['is_declaration'] = $this->request->post('is_declaration', '', 'serach_in');
			$where['is_success'] = $this->request->post('is_success', '', 'serach_in');
		
			$where['is_pay'] = 1;
			
			$where['is_delete'] = 0;
		

			$pay_time = $this->request->post('pay_time', '', 'serach_in');
			$where['pay_time'] = ['between',[$pay_time[0],$pay_time[1]]];

			$field = '*';

			$order  = $this->request->post('order', '', 'serach_in');	//排序字段
			$sort  = $this->request->post('sort', '', 'serach_in');		//排序方式

			$orderby = ($sort && $order) ? $sort.' '.$order : 'id desc';
  //var_dump($where);
			$res = OrderModel::where(formatWhere($where))->field($field)->order($orderby)->paginate(['list_rows'=>$limit,'page'=>$page])->toArray();
			foreach($res['data'] as $k=>$v){
			    $tuis = [];
                
                $tuis['id']=$v['pay_id'];
                
                $Pay = PayModel::field('*')->where(formatWhere($tuis))->find();
                if ($Pay->type==1) {
                    $res['data'][$k]['mch_id']=$Pay->mch_id;
                    $res['data'][$k]['mno']="";
                }else{
                    $res['data'][$k]['mch_id']="";
                    $res['data'][$k]['mno']=$Pay->mno;
                }
                
			}

			$data['status'] = 200;
			$data['data'] = $res;
			//$data['sum_amount'] = OrderModel::where(formatWhere($where))->sum('amount');
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
		OrderModel::update($data);
		return json(['status'=>200,'msg'=>'操作成功']);
	}

	/*
 	* @Description  添加
 	*/
	public function add(){
		$postField = 'username,sex,pic,mobile,email,password,amount,status,ssq,create_time';
		$data = $this->request->only(explode(',',$postField),'post',null);

		$this->validate($data,\app\admin\validate\Membe::class);

		$data['password'] = md5($data['password'].config('my.password_secrect'));
		$data['ssq'] = implode('-',$data['ssq']);
		$data['create_time'] = time();

		try{
			$res = OrderModel::insertGetId($data);
		}catch(\Exception $e){
			throw new ValidateException($e->getMessage());
		}
		return json(['status'=>200,'data'=>$res,'msg'=>'添加成功']);
	}


	/*
 	* @Description  修改
 	*/
	public function update(){
		$postField = 'id,username,sex,pic,mobile,email,amount,status,ssq,create_time';
		$data = $this->request->only(explode(',',$postField),'post',null);

		$this->validate($data,\app\admin\validate\Membe::class);

		$data['ssq'] = implode('-',$data['ssq']);
		$data['create_time'] = strtotime($data['create_time']);

		try{
			OrderModel::update($data);
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
		$field = 'id,username,sex,pic,mobile,email,amount,status,ssq,create_time';
		$res = OrderModel::field($field)->find($id);
		$res['ssq'] = explode('-',$res['ssq']);
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
		    $data['is_delete'] = 1;
		    
		    $res=OrderModel::where(['id'=>$v])->update($data);
		    
		}
	
	
		return json(['status'=>200,'msg'=>'操作成功']);
	}


	/*
 	* @Description  查看详情
 	*/
	function detail(){
		$id =  $this->request->post('id', '', 'serach_in');
		if(!$id) throw new ValidateException ('参数错误');
		$field = 'id,username,sex,pic,mobile,email,amount,status,ssq,create_time';
		$res = OrderModel::field($field)->find($id);
		return json(['status'=>200,'data'=>$res]);
	}


	/*
 	* @Description  重置密码
 	*/
	public function resetPwd(){
		$postField = 'id,password';
		$data = $this->request->only(explode(',',$postField),'post',null);
		if(empty($data['id'])) throw new ValidateException ('参数错误');
		if(empty($data['password'])) throw new ValidateException ('密码不能为空');

		$data['password'] = md5($data['password'].config('my.password_secrect'));
		$res = OrderModel::update($data);
		return json(['status'=>200,'msg'=>'操作成功']);
	}


	/*
 	* @Description  数值加
 	*/
	public function jia(){
		$postField = 'id,amount';
		$data = $this->request->only(explode(',',$postField),'post',null);
		if(empty($data['id'])) throw new ValidateException ('参数错误');
		if(empty($data['amount'])) throw new ValidateException ('值不能为空');
		$res = OrderModel::field('amount')->where('id',$data['id'])->inc('amount',$data['amount'])->update();
		return json(['status'=>200,'msg'=>'操作成功']);
	}


	/*
 	* @Description  数值减
 	*/
	public function jian(){
		$postField = 'id,amount';
		$data = $this->request->only(explode(',',$postField),'post',null);
		if(empty($data['id'])) throw new ValidateException ('参数错误');
		if(empty($data['amount'])) throw new ValidateException ('值不能为空');

		if($data['amount'] > OrderModel::where('id',$data['id'])->value('amount')){
			throw new ValidateException('数据不足');
		}
		$res = OrderModel::field('amount')->where('id',$data['id'])->dec('amount',$data['amount'])->update();
		return json(['status'=>200,'msg'=>'操作成功']);
	}


	/*
 	* @Description  导入
 	*/
	public function importData(){
		$data = $this->request->post();
		$list = [];
		foreach($data as $key=>$val){
			$list[$key]['username'] = $val['用户名'];
			$list[$key]['sex'] = getValByKey($val['性别'],'[{"key":"男","val":"1","label_color":"primary"},{"key":"女","val":"2","label_color":"warning"}]');
			$list[$key]['pic'] = $val['头像'];
			$list[$key]['mobile'] = $val['手机号'];
			$list[$key]['email'] = $val['邮箱'];
			$list[$key]['password'] = $val['密码'] ? md5($val['密码']) : '';
			$list[$key]['amount'] = $val['积分'];
			$list[$key]['status'] = getValByKey($val['状态'],'[{"key":"开启","val":"1"},{"key":"关闭","val":"0"}]');
			$list[$key]['ssq'] = $val['省市区'];
			$list[$key]['create_time'] = time();
		}
		(new OrderModel)->insertAll($list);
		return json(['status'=>200]);
	}


	/*
 	* @Description  客户端导出
 	*/
	function dumpdata(){
		$page = $this->request->param('page', 1, 'intval');
		$limit = config('my.dumpsize') ? config('my.dumpsize') : 1000;

		$state = $this->request->param('state');
		$where = [];
		$where['id'] = ['in',$this->request->param('id', '', 'serach_in')];
		$where['username'] = $this->request->param('username', '', 'serach_in');
		$where['sex'] = $this->request->param('sex', '', 'serach_in');
		$where['mobile'] = $this->request->param('mobile', '', 'serach_in');
		$where['email'] = $this->request->param('email', '', 'serach_in');
		$where['status'] = $this->request->param('status', '', 'serach_in');
		$where['ssq'] = ['like',implode('-',$this->request->param('ssq', [], 'serach_in'))];

		$create_time = $this->request->param('create_time', '', 'serach_in');
		$where['create_time'] = ['between',[strtotime($create_time[0]),strtotime($create_time[1])]];

		$order  = $this->request->param('order', '', 'serach_in');	//排序字段
		$sort  = $this->request->param('sort', '', 'serach_in');		//排序方式

		$orderby = ($sort && $order) ? $sort.' '.$order : 'id desc';

		$field = 'username,sex,pic,mobile,email,password,amount,status,ssq,create_time';

		$res = OrderModel::where(formatWhere($where))->field($field)->order($orderby)->paginate(['list_rows'=>$limit,'page'=>$page])->toArray();

		foreach($res['data'] as $key=>$val){
			$res['data'][$key]['sex'] = getItemVal($val['sex'],'[{"key":"男","val":"1","label_color":"primary"},{"key":"女","val":"2","label_color":"warning"}]');
			$res['data'][$key]['status'] = getItemVal($val['status'],'[{"key":"开启","val":"1"},{"key":"关闭","val":"0"}]');
			$res['data'][$key]['create_time'] = !empty($val['create_time']) ? date('Y-m-d H:i:s',$val['create_time']) : '';
			unset($res['data'][$key]['id']);
		}

		$data['status'] = 200;
		$data['header'] = explode(',','用户名,性别,头像,手机号,邮箱,密码,积分,状态,省市区,创建时间');
		$data['percentage'] = ceil($page * 100/ceil($res['total']/$limit));
		$data['filename'] = '会员管理.'.config('my.dump_extension');
		$data['data'] = $res['data'];
		return json($data);
	}


	/*
 	* @Description  服务端导出
 	*/
	function dumpdata2(){
		$page = $this->request->param('page', 1, 'intval');
		$limit = config('my.dumpsize') ? config('my.dumpsize') : 1000;

		$state = $this->request->param('state');
		$where = [];
		$where['id'] = ['in',$this->request->param('id', '', 'serach_in')];
		$where['username'] = $this->request->param('username', '', 'serach_in');
		$where['sex'] = $this->request->param('sex', '', 'serach_in');
		$where['mobile'] = $this->request->param('mobile', '', 'serach_in');
		$where['email'] = $this->request->param('email', '', 'serach_in');
		$where['status'] = $this->request->param('status', '', 'serach_in');
		$where['ssq'] = ['like',implode('-',$this->request->param('ssq', [], 'serach_in'))];

		$create_time = $this->request->param('create_time', '', 'serach_in');
		$where['create_time'] = ['between',[strtotime($create_time[0]),strtotime($create_time[1])]];

		$order  = $this->request->param('order', '', 'serach_in');	//排序字段
		$sort  = $this->request->param('sort', '', 'serach_in');		//排序方式

		$orderby = ($sort && $order) ? $sort.' '.$order : 'id desc';

		$field = 'username,sex,pic,mobile,email,password,amount,status,ssq,create_time';

		$res = OrderModel::where(formatWhere($where))->field($field)->order($orderby)->paginate(['list_rows'=>$limit,'page'=>$page])->toArray();

		$cache_key = 'Membe';
		if($page == 1){
			cache($cache_key,null);
			cache($cache_key,[]);
		}
		if($res['data']){
			cache($cache_key,array_merge(cache($cache_key),$res['data']));
			$data['percentage'] = ceil($page * 100/ceil($res['total']/$limit));
			$data['state'] =  'ok';
			return json($data);
		}
		if($state == 'ok'){
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();

			$sheet->setCellValue('A1','用户名');
			$sheet->setCellValue('B1','性别');
			$sheet->setCellValue('C1','头像');
			$sheet->setCellValue('D1','手机号');
			$sheet->setCellValue('E1','邮箱');
			$sheet->setCellValue('F1','密码');
			$sheet->setCellValue('G1','积分');
			$sheet->setCellValue('H1','状态');
			$sheet->setCellValue('I1','省市区');
			$sheet->setCellValue('J1','创建时间');

			foreach(cache($cache_key) as $k=>$v){
				$sheet->setCellValue('A'.($k+2),$v['username']);
				$sheet->setCellValue('B'.($k+2),getItemVal($v['sex'],'[{"key":"男","val":"1","label_color":"primary"},{"key":"女","val":"2","label_color":"warning"}]'));
				$sheet->setCellValue('C'.($k+2),$v['pic']);
				$sheet->setCellValue('D'.($k+2),$v['mobile']);
				$sheet->setCellValue('E'.($k+2),$v['email']);
				$sheet->setCellValue('F'.($k+2),$v['password']);
				$sheet->setCellValue('G'.($k+2),$v['amount']);
				$sheet->setCellValue('H'.($k+2),getItemVal($v['status'],'[{"key":"开启","val":"1"},{"key":"关闭","val":"0"}]'));
				$sheet->setCellValue('I'.($k+2),$v['ssq']);
				$sheet->setCellValue('J'.($k+2),!empty($v['create_time']) ? date('Y-m-d H:i:s',$v['create_time']) : '');
			}

			$filename = '会员管理.'.config('my.dump_extension');
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename='.$filename);
 			header('Cache-Control: max-age=0');
			$writer = new Xlsx($spreadsheet);
			$writer->save('php://output');exit;
		}
	}


	//点击申报
	public function declaration(){
		$idx = $this->request->post('id', '', 'serach_in');
		if(empty($idx)) throw new ValidateException ('参数错误');

		$data['is_declaration'] = 1;
		$res = OrderModel::where(['id'=>explode(',',$idx)])->update($data);
		return json(['status'=>200,'msg'=>'操作成功']);
	}
	//申请成功
	public function declaration_success(){
		$idx = $this->request->post('id', '', 'serach_in');
		if(empty($idx)) throw new ValidateException ('参数错误');

		$data['is_success'] = 1;
		$data['status'] = 1;
		$res = OrderModel::where(['id'=>explode(',',$idx)])->update($data);
		if ($res) {
		    $where = [];
            $where['id']=$idx;
  
            $order = OrderModel::where(formatWhere($where))->find();
            
            $wheres = [];
            $wheres['enterprise_code']=$order->enterprise_code;
            $enterprise = EnterpriseModel::where(formatWhere($wheres))->find();
            
            $datas['is_report'] = 1;
            $enterpriseReport = EnterpriseReport::where(['enterprise_code'=>$enterprise->enterprise_code,'report_year'=>$order->report_year])->update($datas);
		  
		}
		
		return json(['status'=>200,'msg'=>'操作成功']);
	}
	
	//申请失败
	public function declaration_fail(){
		$idx = $this->request->post('id', '', 'serach_in');
		if(empty($idx)) throw new ValidateException ('参数错误');
		
		$data['is_success'] = 2;
		$res = OrderModel::where(['id'=>explode(',',$idx)])->update($data);
		return json(['status'=>200,'msg'=>'操作成功']);
	}
	
	public function init($pay_id)  // 支付配置初始化
    {
        
        $paylist = PayModel::where(['id' => $pay_id])->find()->toArray();
        
        $configs = BaseconfigModel::column('data','name');
	    $cert_path=app()->getRootPath().'public'.$paylist['cert_path'];
	    $key_path=app()->getRootPath().'public'.$paylist['key_path'];
	    
	    $config = [
            
            "app_id"=> $configs['appid'],
            "mch_id" =>$paylist['mch_id'] ,
            "key" => $paylist['pay_secretkey'],
            
            'cert_path' => $cert_path, // XXX: 绝对路径！！！！
            'key_path' => $key_path,      // XXX: 绝对路径！！！！
        
        ];
        $app = Factory::payment($config);
  
        return $app;
        
        
    }
    
	
	//退款
	public function refund(){
	    $idx = $this->request->post('id', '', 'serach_in');
	    if(empty($idx)) throw new ValidateException ('参数错误');
	    $order = OrderModel::where('id', $idx)->field('*')->find();
	   
	    if($order['status']==1){
	        throw new ValidateException ('订单已完成不能退款');
	    }
	    if ($order['is_pay']==0) {
	        throw new ValidateException ('待支付不能退款');
            
        }else{
            if ($order['is_refund']==1) {
                throw new ValidateException ('此订单已经退款了');
           
            }
        }
        $out_trade_no = $order['order_no'];   // 商户订单号
        $price=$order['total_price'];
        $pay_id=$order['pay_id'];
	    if($order['pay_type']==1){
	        $app = $this->init($pay_id);
	        $result = $app->refund->byOutTradeNumber($out_trade_no, uniqid(), $price* 100, $price* 100, [
    
                'refund_desc' => '退款',
                
            ]);
         
            if ($result['result_code'] == 'SUCCESS'){
                
                $data['is_refund'] = 1;
                $data['refund_time'] = date('Y-m-d H:i:s');
                $data['status'] = 1;
                
		        OrderModel::where(['order_no'=>$out_trade_no])->update($data);
                
                        
                Log::info('商户订单号:'.$out_trade_no.' 退款成功');
                
                return json(['status'=>200,'msg'=>'退款成功']);
            }   
            else{
                Log::info('商户订单号:'.$out_trade_no.' 退款失败');
              
                return json(['status'=>201,'msg'=>$result['return_msg']]);
              
            }
	        
	    }elseif ($order['pay_type']==2) {
	        
	        $paylist = PayModel::where(['id' => $pay_id])->find()->toArray();
	        // 随行付退款
	        $configs = BaseconfigModel::column('data','name');
	        $privateKey=$paylist['privatekey'];
            $sxfPublic=$paylist['sxfpublic'];
            $aopClient = new AopClient();
            $orderId = 'T'.date('YmdHis').make_random(3);
            $array = [
                //业务参数
                "mno"=> $paylist['mno'], //商户编号
    		    "ordNo"=> $orderId, //商户订单号
    		    //下面三个至少传一个
    		    "origOrderNo"=> "", //原商户订单号
    		    "origUuid"=> "", //原交易科技公司订单号
    		    "origSxfUuid"=> $order['sxfuuid'], //正交易落单号
    		    "amt"=> $price, //正交易落单号
    		   // "notifyUrl"=> "", //回调推送地址，用来接收科技公司的异步推送
    		    "refundReason"=> "退款", //退货原因
    		    "extend"=> "" //备用
        	];
        	$reqBean = [
        		"orgId" =>$paylist['orgid'],
        		"reqData"=>$array,
        		"reqId" => time(),
        		"signType" => "RSA",
        		"timestamp" => date("Y-m-d h:i:s"),
        		"version" => "1.0",
        	];
        	$signContent = $aopClient->generateSign($reqBean,$privateKey);
        	$sign =["sign" => $signContent];
        	$reqStr = array_merge($reqBean, $sign);
        	$reqStr = json_encode($reqStr,320);
        	$requestUrl = 'https://openapi.tianquetech.com/order/refund';
        	$resp = $aopClient->curl($requestUrl, $reqStr);
        	$result = json_decode($resp,320);
        
        	$signResult = $result["sign"];
        	//  result.remove("sign");
        	unset($result["sign"]);
        	if ($result['respData']['bizCode'] == '0000'){
        	    
        	    $data['is_refund'] = 1;
                $data['refund_time'] = date('Y-m-d H:i:s');
                $data['status'] = 1;
        	    OrderModel::where(['order_no'=>$out_trade_no])->update($data);
        	    return json(['status'=>200,'msg'=>'退款成功']);
        
        	}else{
        
        	    return json(['status'=>201,'msg'=>$result['respData']['bizMsg']]);
        	}
	        
	    }
	    
	   
	    
	    
	     
       
	    
	}
	
	




}

