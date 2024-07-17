<?php
namespace app\admin\controller;
use think\facade\Db;

use app\admin\model\Member as MemberModel;
use app\admin\model\Order as OrderModel;
use app\admin\model\Enterprise as EnterpriseModel;
class Index extends Admin {
	
	
	public function index(){
		return view('index');
	}
	
	
	//后台首页主体内容
	public function main(){
		if(!$this->request->isPost()){
			return view('main');
		}else{
		    $days = date("t");
		    for ($i = 0; $i < intval($days); $i++)
            {
                 # 获取当月每天
                 $day[] = date('d', strtotime("+" .$i. " day", strtotime(date("Y-m-01"))));
                 # 获取每天开始时间
                 $start = date('Y-m-d H:i:s', strtotime("+" . $i . " day", strtotime(date("Y-m-01 00:00:00"))));
                 # 获取每天结束时间
                 $end = date('Y-m-d H:i:s', strtotime("+" . $i . " day", strtotime(date("Y-m-01 23:59:59"))));
                 
                 $where = [];
                 $where['create_time']=['between',[$start,$end]];
                 $where['is_pay']=1;
            
                 $data[] = OrderModel::field('*')->where(formatWhere($where))->count();
                //  $time=strtotime("+" .$i. " day", strtotime(date("Y-m-01")));
                //  $time=date("Y-m-d H:i:s",$time);
                
    		    
                       
            }
			//折线图数据
			$echat_data['day_count'] = [
				'title'=>'当月订单折线图',
				'day'=>$day,	//每月天数
				'data'=>$data	//每天数据
			];
			
			if(config('my.show_home_chats',true)){
				$data['echat_data'] = $echat_data;
			}
			$data['card_data'] = $this->getCardData();
			$data['status'] = 200;
			return json($data);
		}
	}
	
	
	
	//首页统计数据
	private function getCardData(){
	    $start = date('Y-m-01 00:00:00');
	    $end = date('Y-m-d 23:59:59', strtotime('Last day of this month'));
	    $where = [];
        $where['create_time']=['between',[$start,$end]];
       
        $useryue= MemberModel::field('*')->where(formatWhere($where))->count();
        
        $where['is_pay']=1;
        $orderyue= OrderModel::field('*')->where(formatWhere($where))->count();
        
        $wheres = [];
        $wheres['create_time']=['between',[$start,$end]];
        $wheres['is_pay']=1;
        $moneyyue = OrderModel::field('*')->where(formatWhere($wheres))->sum('total_price');
        
        
        $beginToday = date('Y-m-d 00:00:00', time());

        //今天结束
        
        $endToday = date('Y-m-d 23:59:59', time());
        $wheres = [];

        $wheres['create_time']=['between',[$beginToday,$endToday]];
        $userday= MemberModel::field('*')->where(formatWhere($wheres))->count();
        
        $wheres['is_pay']=1;
        $orderday= OrderModel::field('*')->where(formatWhere($wheres))->count();
        
        $whe = [];
        $whe['create_time']=['between',[$beginToday,$endToday]];
        $whe['is_pay']=1;
        $moneyday = OrderModel::field('*')->where(formatWhere($whe))->sum('total_price');
        
		$card_data = [	//头部统计数据
			[
			  'title_icon'=>"el-icon-s-order",
			  'card_title'=> "订单",
			  'card_cycle'=> "月",
			  'card_cycle_back_color'=> "#409EFF",
			  'bottom_title'=> "订单总量",
			  'vist_num'=> $orderday,
			  'vist_all_num'=> $orderyue,
			  'vist_all_icon'=> "el-icon-trophy",
			],
			/*[
			  'title_icon'=> "el-icon-office-building",
			  'card_title'=> "企业",
			  'card_cycle'=> "月",
			  'card_cycle_back_color'=> "#67C23A",
			  'bottom_title'=> "企业总量",
			  'vist_num'=> rand(0,100000),
			  'vist_all_num'=> rand(0,100000),
			  'vist_all_icon'=> "el-icon-download",
			],*/
			[
			  'title_icon'=> "el-icon-wallet",
			  'card_title'=> "收入",
			  'card_cycle'=> "月",
			  'card_cycle_back_color'=> "#F56C6C",
			  'bottom_title'=> "总收入",
			  'vist_num'=>$moneyday,
			  'vist_all_num'=> $moneyyue,
			  'vist_all_icon'=> "el-icon-coin",
			],
			[
			  'title_icon'=> "el-icon-coordinate",
			  'card_title'=> "用户",
			  'card_cycle'=> "月",
			  'card_cycle_back_color'=> "#E6A23C",
			  'bottom_title'=> "总用户",
			  'vist_num'=> $userday,
			  'vist_all_num'=> $useryue,
			  'vist_all_icon'=> "el-icon-data-line",
			],
		];
		
		return $card_data;
	}
	
	
	
	
}