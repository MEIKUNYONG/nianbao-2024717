<?php 
/*
 module:		日志管理控制器
 create_time:	2022-05-26 09:46:19
 author:		
 contact:		
*/

namespace app\admin\controller;
use think\exception\ValidateException;
use app\admin\model\Log as LogModel;
use think\facade\Db;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Log extends Admin {


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
			$where['username'] = $this->request->post('username', '', 'serach_in');

			$create_time = $this->request->post('create_time', '', 'serach_in');
			$where['create_time'] = ['between',[strtotime($create_time[0]),strtotime($create_time[1])]];
			$where['type'] = $this->request->post('type', '', 'serach_in');

			$field = 'id,application_name,username,url,ip,create_time,type';

			$order  = $this->request->post('order', '', 'serach_in');	//排序字段
			$sort  = $this->request->post('sort', '', 'serach_in');		//排序方式

			$orderby = ($sort && $order) ? $sort.' '.$order : 'id desc';

			$res = LogModel::where(formatWhere($where))->field($field)->order($orderby)->paginate(['list_rows'=>$limit,'page'=>$page])->toArray();

			$data['status'] = 200;
			$data['data'] = $res;
			return json($data);
		}
	}


	/*
 	* @Description  删除
 	*/
	function delete(){
		$idx =  $this->request->post('id', '', 'serach_in');
		if(!$idx) throw new ValidateException ('参数错误');
		LogModel::destroy(['id'=>explode(',',$idx)],true);
		return json(['status'=>200,'msg'=>'操作成功']);
	}


	/*
 	* @Description  查看详情
 	*/
	function detail(){
		$id =  $this->request->post('id', '', 'serach_in');
		if(!$id) throw new ValidateException ('参数错误');
		$field = 'id,application_name,username,url,ip,useragent,content,errmsg,create_time,type';
		$res = LogModel::field($field)->find($id);
		return json(['status'=>200,'data'=>$res]);
	}


	/*
 	* @Description  导出
 	*/
	function dumpdata(){
		$page = $this->request->param('page', 1, 'intval');
		$limit = config('my.dumpsize') ? config('my.dumpsize') : 1000;

		$state = $this->request->param('state');
		$where = [];
		$where['id'] = ['in',$this->request->param('id', '', 'serach_in')];
		$where['username'] = $this->request->param('username', '', 'serach_in');

		$create_time = $this->request->param('create_time', '', 'serach_in');
		$where['create_time'] = ['between',[strtotime($create_time[0]),strtotime($create_time[1])]];
		$where['type'] = $this->request->param('type', '', 'serach_in');

		$order  = $this->request->param('order', '', 'serach_in');	//排序字段
		$sort  = $this->request->param('sort', '', 'serach_in');		//排序方式

		$orderby = ($sort && $order) ? $sort.' '.$order : 'id desc';

		$field = 'application_name,username,url,ip,useragent,content,errmsg,create_time,type';

		$res = LogModel::where(formatWhere($where))->field($field)->order($orderby)->paginate(['list_rows'=>$limit,'page'=>$page])->toArray();

		$cache_key = 'Log';
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

			$sheet->setCellValue('A1','应用名');
			$sheet->setCellValue('B1','用户名');
			$sheet->setCellValue('C1','请求url');
			$sheet->setCellValue('D1','客户端ip');
			$sheet->setCellValue('E1','浏览器信息');
			$sheet->setCellValue('F1','请求内容');
			$sheet->setCellValue('G1','异常信息');
			$sheet->setCellValue('H1','创建时间');
			$sheet->setCellValue('I1','类型');

			foreach(cache($cache_key) as $k=>$v){
				$sheet->setCellValue('A'.($k+2),$v['application_name']);
				$sheet->setCellValue('B'.($k+2),$v['username']);
				$sheet->setCellValue('C'.($k+2),$v['url']);
				$sheet->setCellValue('D'.($k+2),$v['ip']);
				$sheet->setCellValue('E'.($k+2),$v['useragent']);
				$sheet->setCellValue('F'.($k+2),$v['content']);
				$sheet->setCellValue('G'.($k+2),$v['errmsg']);
				$sheet->setCellValue('H'.($k+2),!empty($v['create_time']) ? date('Y-m-d H:i:s',$v['create_time']) : '');
				$sheet->setCellValue('I'.($k+2),getItemVal($v['type'],'[{"key":"登录日志","val":"1","label_color":"info"},{"key":"操作日志","val":"2","label_color":"warning"},{"key":"异常日志","val":"3","label_color":"danger"}]'));
			}

			$filename = '日志管理.'.config('my.dump_extension');
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename='.$filename);
 			header('Cache-Control: max-age=0');
			$writer = new Xlsx($spreadsheet);
			$writer->save('php://output');exit;
		}
	}




}

