<?php 

namespace app\api\controller;
use app\api\BaseController;
use app\api\middleware\ApiMiddleware;
use app\admin\model\Baseconfig as BaseconfigModel;
use app\admin\model\Enterprise as EnterpriseModel;

use app\admin\model\MemberEnterprise;

use app\admin\model\EnterpriseReport;

use SingKa\Sms\sksms;
use think\facade\Config;
class Index extends BaseController
{
  
    protected $middleware = [ 
    	ApiMiddleware::class . ':api' 	=> ['except' 	=> ['index','config','geturlscheme'] ]
    ];
    
  
    /**
     * 请求接口返回内容
     * @param  string $url [请求的URL地址]
     * @param  string $params [请求的参数]
     * @param  int $ipost [是否采用POST形式]
     * @return  string
     */
    public function freeApiCurl($url,$params=false,$ispost=0){
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
        curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 60 );
        curl_setopt( $ch, CURLOPT_TIMEOUT , 60);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
        if( $ispost )
        {
            curl_setopt( $ch , CURLOPT_POST , true );
            curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
            curl_setopt( $ch , CURLOPT_URL , $url );
        }
        else
        {
            if($params){
                curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
            }else{
                curl_setopt( $ch , CURLOPT_URL , $url);
            }
        }
        $response = curl_exec( $ch );
        if ($response === FALSE) {
            return false;
        }
        curl_close( $ch );
        return $response;
    }
    
    
    
    
    public function config()
    {
        $config = BaseconfigModel::column('data','name');
        
        $list=[];
        $list['wxtitle']=$config['wxtitle'];
        $list['wxlogo']=$config['wxlogo'];
        $list['db_img']=$config['db_img'];
        
        $list['agreement_title']=$config['agreement_title'];
        $list['agreement_content']=$config['agreement_content'];
        
        $list['privacy_title']=$config['privacy_title'];
        $list['privacy_content']=$config['privacy_content'];
        
        $list['topleft_logo']=$config['topleft_logo'];
        $list['topright_logo']=$config['topright_logo'];
        
        $list['bottom_copyright']=$config['bottom_copyright'];
        $list['article_link']=$config['article_link'];
        
        $list['top_word']=$config['top_word'];
        
        $list['shoptop_logo']=$config['shoptop_logo'];
        
        $list['is_mo']=$config['is_mo'];
        $list['noareafee']=$config['noareafee'];
        
        $list['ycpic']=$config['ycpic'];
        $list['qypic']=$config['qypic'];
        
        
        $list['is_kefu']=$config['is_kefu'];
        $list['service_telephone']=$config['service_telephone'];
        
        
        $data = ['code' =>200,'data'=>$list,'msg' => '获取成功'];
        return json($data);
    }
    //获取首页登录之后企业信息
    public function information()
    {
        $member= $this->request->member;
        $mobile=$member->mobile;//手机号
        
        $wheres = [];
        $wheres['member_mobile']=$mobile;

        $MemberEnterprise = MemberEnterprise::where(formatWhere($wheres))->order('id desc')->find();
        if (!$MemberEnterprise) {
            $where = [];
            $where['mobile']=$mobile;
            $enterprise = EnterpriseModel::where(formatWhere($where))->find();
            
            if($enterprise){
                $memberenter=new MemberEnterprise;
                $memberenter->member_id=$member->id;
                $memberenter->enterprise_id=$enterprise->id;
                $memberenter->member_mobile=$mobile;
                $memberenter->status=1;
          
                if ($memberenter->save()) {
                    //数据库中有企业证明是提前导入的，查询年报表是否有此数据
                    $lastYear = date('Y', strtotime('-1 year'));
                    $whe = [];
                   
                    $whe['enterprise_code']=$enterprise->enterprise_code;
                    $whe['report_year']=$lastYear;
                    $report = EnterpriseReport::where(formatWhere($whe))->find();
                    if (!$report) {
                        // 获取去年的年份
                        
                        $enterpriseReport=new EnterpriseReport;
                        $enterpriseReport->enterprise_code=$enterprise->enterprise_code;
                        $enterpriseReport->report_year=$lastYear;
                        $enterpriseReport->is_report=0;
                        $enterpriseReport->save();
                        
                        $is_report=0;
                    }else{
                        $is_report=$report->is_report;
                    }
                    
                    
                    $list=[];
                    $list['id']=$memberenter->id;
                    $list['enterprise_name']=$enterprise->enterprise_name;
                    $list['mobile']=$mobile;
                    $list['is_report']=$is_report;
                    $data = ['code' =>200,'data'=>$list,'msg' => '获取成功'];
                    return json($data);
                }
                
            }else {
                $list=[];
                $data = ['code' =>200,'data'=>$list,'msg' => '获取成功'];
                return json($data);
            }
            
        }else{
            //中间表有
            $where = [];
            $where['id']=$MemberEnterprise->enterprise_id;
  
            $enterprise = EnterpriseModel::where(formatWhere($where))->find();
            $lastYear = date('Y', strtotime('-1 year'));
            $whe = [];
   
            $whe['enterprise_code']=$enterprise->enterprise_code;
            $whe['report_year']=$lastYear;
            $report = EnterpriseReport::where(formatWhere($whe))->find();
            $is_report=$report->is_report;
            
            $list=[];
            $list['id']=$MemberEnterprise->id;
            $list['enterprise_name']=$enterprise->enterprise_name;
            $list['mobile']=$mobile;
            $list['is_report']=$is_report;
            $data = ['code' =>200,'data'=>$list,'msg' => '获取成功'];
            return json($data);
            
        }
        
        
    }
    //查询企业
    public function getenterprise()
    {
        $data= $this->request->post();
        $keyword=$data['keyword'];
        
        $member= $this->request->member;
        $mobile=$member->mobile;//手机号
        //先查询自己数据库
        $where = [];
        $where['enterprise_name'] =['like',$keyword];;
        
        $enterprise =  EnterpriseModel::where(formatWhere($where))->select()->toArray();
        
        if($enterprise){
            $arr=[];
            foreach ($enterprise as $ko=>$vo) {
                
                $lastYear = date('Y', strtotime('-1 year'));
                $whe = [];

                $whe['enterprise_code']=$vo['enterprise_code'];
                $whe['report_year']=$lastYear;
                $report = EnterpriseReport::where(formatWhere($whe))->find();
                if (!$report) {
                        // 获取去年的年份
                        
                    $enterpriseReport=new EnterpriseReport;

                    $enterpriseReport->enterprise_code=$vo['enterprise_code'];
                    $enterpriseReport->report_year=$lastYear;
                    $enterpriseReport->is_report=0;
                    $enterpriseReport->save();
                        
                    $is_report=0;
                }else{
                    $is_report=$report->is_report;
                }
           
                $str=[];
                $str['enterprise_id']=$vo['id'];
                $str['enterprise_name']=$vo['enterprise_name'];
                $str['enterprise_code']=$vo['enterprise_code'];
                $str['legal_person']=$vo['legal_person'];
                //$str['is_havedata']=1;
                $str['is_report']=$is_report;
                $arr[]=$str;
            }
            
            return json(['code' =>200,'data'=>$arr,'msg' => '获取成功']);
            
        }else{
            $config = BaseconfigModel::column('data','name');
            $urls = 'https://api.qichacha.com/FuzzySearch/GetList';
            $is_nbapi = $config['is_nbapi'];
            $apiKey = $config['key'];
            $SecretKey = $config['secretkey'];
            if (!($apiKey && $SecretKey)) {
         
                return json(['code' =>201,'msg' => '请先在后台配置对应信息']);
            }
            $url = $urls.'?key='.$apiKey.'&searchKey='.$keyword;
            
            
            $timeSpan = time();
            // 加密
            $token =  strtoupper(md5($apiKey.$timeSpan.$SecretKey));
            $header = array("Token:{$token}","Timespan:{$timeSpan}");
           
            // 请求参数
            $content = [
                'key' => $apiKey,
                'searchKey' => $keyword
               
            ];
      
            // 发送请求
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($ch);
            curl_close($ch);
            // 处理返回结果
            $result = json_decode($result, true);
           
            if ($result['Status'] == '200') {
                $list=$result['Result'];
                $arr=[];
                foreach ($list as $k=>$v) {
                    $shuju = new EnterpriseModel();
                    $shuju->enterprise_name=$v['Name'];
                    $shuju->enterprise_code=$v['CreditCode'];
                    $shuju->legal_person=$v['OperName'];
                    $shuju->mobile=$mobile;
                    $shuju->status=1;
                    $shuju->is_special=0;
                    
                    $shuju->save();
                    //这里之后会写第三方api判断上一年是否年报的判断
                    if ($is_nbapi==1) {
                       //这里之后会写第三方api判断上一年是否年报的判断
                    }else{
                        $is_report=0;
                    }
                    
                    //**********************
                    //如果通过api查询2022年年报已经有了那么
                    $lastYear = date('Y', strtotime('-1 year'));
                    $enterpriseReport=new EnterpriseReport;

                    $enterpriseReport->enterprise_code=$v['CreditCode'];
                    $enterpriseReport->report_year=$lastYear;
                    $enterpriseReport->is_report=$is_report;
                    $enterpriseReport->save();
                  
                    
                    $str=[];
                    $str['enterprise_name']=$v['Name'];
                    $str['enterprise_code']=$v['CreditCode'];
                    $str['legal_person']=$v['OperName'];
                    //$str['is_havedata']=0;
                    $str['is_report']=$is_report;
                    $arr[]=$str;
                }
                
                return json(['code' =>200,'data'=>$arr,'msg' => '获取成功']);
                 
            } else {
                // 请求失败
                return json(['code' =>201,'data'=>[],'msg' =>$result['Message']]);
               // echo $result['Message'];
            }
        
           
        }
        
        

        //var_dump($token);

        
    }
    
    public function tocurl($url, $headers)
    {
        //初始化
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 0);

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        //执行命令
        $data = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        return $data;
    }
    //绑定
    public function binding()
    {
        $data= $this->request->post();
        //$enterprise_id=$data['enterprise_id'];//企业id已存在数据库中
        
        $enterprise_name=$data['enterprise_name'];//企业名称
        $enterprise_code=$data['enterprise_code'];//代码
        $legal_person=$data['legal_person'];//法人
        
        $member= $this->request->member;
        $mobile=$member->mobile;//手机号
        
        $where = [];
        $where['enterprise_code']=$enterprise_code;
  
        $enterprise = EnterpriseModel::where(formatWhere($where))->find();
      
        if (!$enterprise) {
            $enter=new EnterpriseModel;
            $enter->enterprise_name=$enterprise_name;
            $enter->enterprise_code=$enterprise_code;
            $enter->legal_person=$legal_person;
            $enter->mobile=$mobile;
            $enter->is_special=0;
            $enter->status=1;
            if ($enter->save()) {
                $memberenter=new MemberEnterprise;
                $memberenter->member_id=$member->id;
                $memberenter->enterprise_id=$enter->id;
                $memberenter->member_mobile=$mobile;
                $memberenter->status=1;
                $memberenter->save();
                
                $lastYear = date('Y', strtotime('-1 year'));
                $whe = [];
             
                $whe['enterprise_code']=$enterprise->enterprise_code;
                $whe['report_year']=$lastYear;
                $report = EnterpriseReport::where(formatWhere($whe))->find();
                if (!$report) {
                        // 获取去年的年份
                        
                    $enterpriseReport=new EnterpriseReport;

                    $enterpriseReport->enterprise_code=$enterprise->enterprise_code;
                    $enterpriseReport->report_year=$lastYear;
                    $enterpriseReport->is_report=0;
                    $enterpriseReport->save();
                        
                    $is_report=0;
                }else{
                    $is_report=$report->is_report;
                }
                
                $list=[];
                            
                $list['id']=$memberenter->id;
                $list['enterprise_name']=$enter->enterprise_name;
                $list['mobile']=$mobile;
                $list['is_report']=$is_report;
                $data = ['code' =>200,'data'=>$list,'msg' => '绑定成功'];
                return json($data);
                
            }
        }else{
            //如果数据库存在企业
            $wheres = [];
            $wheres['enterprise_id']=$enterprise->id;
            $wheres['member_mobile']=$mobile;

            $MemberEnterprise = MemberEnterprise::where(formatWhere($wheres))->find();
            
            $lastYear = date('Y', strtotime('-1 year'));
            $whe = [];
        
            $whe['enterprise_code']=$enterprise->enterprise_code;
            $whe['report_year']=$lastYear;
            $report = EnterpriseReport::where(formatWhere($whe))->find();
                
            if (!$report) {
                        // 获取去年的年份
                        
                $enterpriseReport=new EnterpriseReport;

                $enterpriseReport->enterprise_code=$enterprise->enterprise_code;
                $enterpriseReport->report_year=$lastYear;
                $enterpriseReport->is_report=0;
                $enterpriseReport->save();
                        
                $is_report=0;
            }else{
                $is_report=$report->is_report;
            }
            $list=[];
            if(!$MemberEnterprise){
                $memberenter=new MemberEnterprise;
                $memberenter->member_id=$member->id;
                $memberenter->enterprise_id=$enterprise->id;
                $memberenter->member_mobile=$mobile;
                $memberenter->status=1;
                $memberenter->save();
                $list['id']=$memberenter->id;
                
            }else{
                $list['id']=$MemberEnterprise->id;
            }

            $list['enterprise_name']=$enterprise->enterprise_name;
            $list['mobile']=$mobile;
            $list['is_report']=$is_report;
            $data = ['code' =>200,'data'=>$list,'msg' => '绑定成功'];
            return json($data);
        }
    }
    //更换主体里企业列表
    public function enterpriselist()
    {
        $member= $this->request->member;
        $mobile=$member->mobile;//手机号
        $wheres = [];
       
        $wheres['member_mobile']=$mobile;

        $MemberEnterprise = MemberEnterprise::where(formatWhere($wheres))->order('id desc')->select();
        $arr=[];
        foreach ($MemberEnterprise as $k=>$v){
            $str=[];
            $str['id']=$v['id'];
            $where = [];
            $where['id']=$v['enterprise_id'];
      
            $enterprise = EnterpriseModel::where(formatWhere($where))->find();
            $str['enterprise_name']=$enterprise['enterprise_name'];
            
            $str['mobile']=$mobile;
            
            $lastYear = date('Y', strtotime('-1 year'));
            $whe = [];
    
            $whe['enterprise_code']=$enterprise->enterprise_code;
            $whe['report_year']=$lastYear;
            $report = EnterpriseReport::where(formatWhere($whe))->find();
            
            $str['is_report']=$report->is_report;
            $arr[]=$str;
        }
        $data = ['code' =>200,'data'=>$arr,'msg' => '成功'];
        return json($data);
      
        
    }
    
    //年报页面配置
    public function report_config()
    {
        $config = BaseconfigModel::column('data','name');
        
        $list=[];
      
        
        
        $list['service_telephone']=$config['service_telephone'];
        
        // 获取今年的年份
        $thisYear = date('Y');
        
        // 获取去年的年份
        $lastYear = date('Y', strtotime('-1 year'));
        
    

        $list['thisyear']=$thisYear;
        $list['lastyear']=$lastYear;
        
        
        /*$list['normal_content']=$config['normal_content'];
        $list['special_content']=$config['special_content'];*/
   
        $data = ['code' =>200,'data'=>$list,'msg' => '获取成功'];
        return json($data);
    }
    
    //获取企业信息和价格
    public function enterprise()
    {
        $member= $this->request->member;
        $mobile=$member->mobile;//手机号
        
        $data= $this->request->post();
        $id=$data['id'];//中间表id
        $wheres = [];
        $wheres['id']=$id;
      
        $MemberEnterprise = MemberEnterprise::where(formatWhere($wheres))->find();
        $where = [];
        $where['id']=$MemberEnterprise['enterprise_id'];
      
        $enterprise = EnterpriseModel::where(formatWhere($where))->find();
        $list=[];
        $list['enterprise_id']=$enterprise->id;
        $list['enterprise_name']=$enterprise->enterprise_name;
        $list['enterprise_code']=$enterprise->enterprise_code;
        $list['legal_person']=$enterprise->legal_person;
        
        $lastYear = date('Y', strtotime('-1 year'));
        $whe = [];

        $whe['enterprise_code']=$enterprise->enterprise_code;
        $whe['report_year']=$lastYear;
        $report = EnterpriseReport::where(formatWhere($whe))->find();
        $is_report=$report->is_report;
        
        $is_special=$enterprise->is_special;
        $config = BaseconfigModel::column('data','name');
        $list['is_report']=$is_report;
        
        if($is_report==1){
            $list['member_mobile']=$mobile;
            $list['wxtitle']=$config['wxtitle'];
           
        }else{
            $list['submitted_title']=$config['submitted_title'];
            $list['db_img']=$config['db_img'];
            $list['title']='排污许可登记服务费';
            // 获取今年的年份
            $thisYear = date('Y');
            $list['thisyear']=$thisYear;
            if($is_special==1){
                $list['price']=$config['specialfee'];
                $list['agreement']=$config['special_content'];
                
                $list['prompt']=$config['specialprompt'];
            }else{
                $list['price']=$config['normalfee'];
                $list['agreement']=$config['normal_content'];
                $list['prompt']=$config['normalprompt'];
                
            }
        }
        
        
        
        $list['service_telephone']=$config['service_telephone'];
        
        
        
        // 获取去年的年份
        $lastYear = date('Y', strtotime('-1 year'));
        
    
        
        
        $list['lastyear']=$lastYear;
        
        
        $data = ['code' =>200,'data'=>$list,'msg' => '获取成功'];
        return json($data);

        
    }
    
    //h5中间页
    //生成跳转Scheme
    public function geturlscheme()
    {
        $data= $this->request->get();
        $mobile=$data['mobile'];
        $id=$data['id'];
       
        $configs = BaseconfigModel::column('data','name');
        $appId = $configs['appid'];
        $appsecret = $configs['appsecret'];
        $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appId.'&secret='.$appsecret;
        $format="get";
        $datas=null;
        $headerArray=array("Content-type:application/json;","Accept:application/json");
        $res = $this->httpRequest($url,$format,$datas,$headerArray);
        $accessToken = isset($res['access_token']) ? $res['access_token'] : '';
        
        $list = $this->httpRequest(
            'https://api.weixin.qq.com/wxa/generatescheme?access_token='.$accessToken,
            'post',
            [
                'jump_wxa' => [
                    'path' => "/pages/index/index",//跳转小程序地址
                    'query' => "mobile=".$mobile."&id=$id",//跳转小程序额外参数
                    'env_version' => "release",
                ],
                'expire_type' => 0
            ]
        );
        $openlink = isset($list['openlink']) ? $list['openlink'] : '';
        
        $arr=[];
        $arr['title']=$configs['wxtitle'];
        $arr['text']="请打开微信，访问".$configs['wxtitle']."小程序了解年报报送";
        $arr['logo']=$configs['wxlogo'];
        $arr['openlink']=$openlink;
   
        return json(['code' =>200,'data'=>$arr,'msg' => '获取成功']);
        
        
    }
    
     public function vget($url){
        $info=curl_init();
        curl_setopt($info,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($info,CURLOPT_HEADER,0);
        curl_setopt($info,CURLOPT_NOBODY,0);
        curl_setopt($info,CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($info,CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($info,CURLOPT_URL,$url);
        $output= curl_exec($info);
        curl_close($info);
        return $output;
    }
    
    /**
     * curl
     */
    public function httpRequest($url, $format = 'get', $data = null, $headerArray = []){
        //设置头信息
        $curl=curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if ($format == 'post') {
            //post传值设置post传参
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data) {
                $data  = json_encode($data);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            }
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        if ($headerArray) {
            curl_setopt($curl,CURLOPT_HTTPHEADER,$headerArray);
        }
        $data=json_decode(curl_exec($curl), true);
        curl_close($curl);
        //返回接口返回数据
        return $data;
    }
    
    /**
    * 短信发送示例
    *
    * @mobile  短信发送对象手机号码
    * @action  短信发送场景，会自动传入短信模板
    * @parme   短信内容数组
    */
    public function sendSms($mobile, $action, $parme)
    {
        //$this->SmsDefaultDriver是从数据库中读取的短信默认驱动
        $SmsDefaultDriver = 'qcloud'; 
        //$this->SmsConfig是从数据库中读取的短信配置
        $config = Config::get('sms.'.$SmsDefaultDriver);
        $sms = new sksms($SmsDefaultDriver, $config);//传入短信驱动和配置信息
        //判断短信发送驱动，非阿里云和七牛云，需将内容数组主键序号化
        
        $result = $sms->$action($mobile, $this->restoreArray($parme));
        var_dump($result);
        die();
        if ($result['code'] == 200) {
            $data['code'] = 200;
            $data['msg'] = '短信发送成功';
        } else {
            $data['code'] = $result['code'];
            $data['msg'] = $result['msg'];
        }
        return $data;
        
    }
    
    /**
    * 数组主键序号化
    *
    * @arr  需要转换的数组
    */
    public function restoreArray($arr)
    {
        if (!is_array($arr)){
            return $arr;
        }
        $c = 0;
        $new = [];
        foreach ($arr as $key => $value) {
            $new[$c] = $value;
            $c++;
        }
        return $new;
    }
    
    public function send()
    {
        //查找数据库一键发送未年报提醒短信
        //循环遍历年报表查找出未年报的企业code根据企业代码去企业表里查询对应的电话，然后触发发送短信提醒
        $whe = [];
        $lastYear = date('Y', strtotime('-1 year'));

        $whe['report_year']=$lastYear;
        $whe['is_report']=0;
        $report = EnterpriseReport::where(formatWhere($whe))->select();
        foreach ($report as $k=>$v){
            $enterprise_code=$v['enterprise_code'];
            
            $where = [];
            $where['enterprise_code']=$enterprise_code;
          
            $enterprise = EnterpriseModel::where(formatWhere($where))->find();
            
            $mobile=$enterprise->mobile;
            
            
            var_dump($mobile);
        }
        
        
        die();
        /*$mobile="";
        $action="report";
      
        $parme = ["金牛区青城网络工作室，您的工商年报还未报送","请点击 28182.cn/JcZMfd 退订T"];*/
        
        $target = "http://api.yx.ihuyi.com/webservice/sms.php?method=Submit";
        $mobile = '';//手机号码，多个号码请用,隔开
        $account="";
        $password="";
        $post_data = "account=$account&password=$password&mobile=".$mobile."&content=".rawurlencode("尊敬的会员，您好，夏季新品已上市，请关注。退订回T【领客】");
        //用户名是登录用户中心->营销短信->产品总览->APIID
        //查看密码请登录用户中心->营销短信->产品总览->APIKEY
        $gets = $this->xml_to_array($this->getPost($post_data, $target));
        
        
        if($gets['SubmitResult']['code']==2){
        	echo '提交成功';
        }
        
        //$this->sendSms($mobile, $action, $parme);
        
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
    //获取企业信息
    public function getmo_enterprise()
    {
        $data= $this->request->post();
        $keyword=$data['keyword'];
        
        $member= $this->request->member;
        $mobile=$member->mobile;//手机号
        //先查询自己数据库
        $where = [];
        $where['enterprise_name'] =['like',$keyword];;
        
        $enterprise =  EnterpriseModel::where(formatWhere($where))->select()->toArray();
        
        if($enterprise){
            $config = BaseconfigModel::column('data','name');
            $arr=[];
            foreach ($enterprise as $ko=>$vo) {
                
                $lastYear = date('Y', strtotime('-1 year'));
                $whe = [];

                $whe['enterprise_code']=$vo['enterprise_code'];
                $whe['report_year']=$lastYear;
                $report = EnterpriseReport::where(formatWhere($whe))->find();
                if (!$report) {
                        // 获取去年的年份
                        
                    $enterpriseReport=new EnterpriseReport;

                    $enterpriseReport->enterprise_code=$vo['enterprise_code'];
                    $enterpriseReport->report_year=$lastYear;
                    $enterpriseReport->is_report=0;
                    $enterpriseReport->save();
                        
                    $is_report=0;
                }else{
                    $is_report=$report->is_report;
                }
           
                $str=[];
                $str['enterprise_id']=$vo['id'];
                $str['enterprise_name']=$vo['enterprise_name'];
                $str['enterprise_code']=$vo['enterprise_code'];
                $str['legal_person']=$vo['legal_person'];
                //$str['is_havedata']=1;
                $str['is_report']=$is_report;
                $str['noareafee']=$config['noareafee'];
                $arr[]=$str;
            }
            
            return json(['code' =>200,'data'=>$arr,'msg' => '获取成功']);
            
        }else{
            $config = BaseconfigModel::column('data','name');
            $urls = 'https://api.qichacha.com/FuzzySearch/GetList';
           
            $apiKey = $config['key'];
            $SecretKey = $config['secretkey'];
            if (!($apiKey && $SecretKey)) {
         
                return json(['code' =>201,'msg' => '请先在后台配置对应信息']);
            }
            $url = $urls.'?key='.$apiKey.'&searchKey='.$keyword;
            
            
            $timeSpan = time();
            // 加密
            $token =  strtoupper(md5($apiKey.$timeSpan.$SecretKey));
            $header = array("Token:{$token}","Timespan:{$timeSpan}");
           
            // 请求参数
            $content = [
                'key' => $apiKey,
                'searchKey' => $keyword
               
            ];
      
            // 发送请求
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($ch);
            curl_close($ch);
            // 处理返回结果
            $result = json_decode($result, true);
            
            if ($result['Status'] == '200') {
                $list=$result['Result'];
                $arr=[];
                foreach ($list as $k=>$v) {
                    $shuju = new EnterpriseModel();
                    $shuju->enterprise_name=$v['Name'];
                    $shuju->enterprise_code=$v['CreditCode'];
                    $shuju->legal_person=$v['OperName'];
                    $shuju->mobile=$mobile;
                    $shuju->status=1;
                    $shuju->is_special=0;
                    
                    $shuju->save();
                    //这里之后会写第三方api判断上一年是否年报的判断
                    
                    $is_report=1;
                    //**********************
                    //如果通过api查询2022年年报已经有了那么
                    $lastYear = date('Y', strtotime('-1 year'));
                    $enterpriseReport=new EnterpriseReport;

                    $enterpriseReport->enterprise_code=$v['CreditCode'];
                    $enterpriseReport->report_year=$lastYear;
                    $enterpriseReport->is_report=$is_report;
                    $enterpriseReport->save();
                  
                    
                    $str=[];
                    $str['enterprise_id']=$shuju->id;
                    $str['enterprise_name']=$v['Name'];
                    $str['enterprise_code']=$v['CreditCode'];
                    $str['legal_person']=$v['OperName'];
                    //$str['is_havedata']=0;
                    $str['is_report']=$is_report;
                    $str['noareafee']=$config['noareafee'];
                    $arr[]=$str;
                }
                
                return json(['code' =>200,'data'=>$arr,'msg' => '获取成功']);
                 
            } else {
                // 请求失败
                return json(['code' =>201,'data'=>[],'msg' =>$result['Message']]);
               // echo $result['Message'];
            }
        }
    }
    
    
    //模板
    public function getmo_information()
    {
        $member= $this->request->member;
        $mobile=$member->mobile;//手机号
        
        $data= $this->request->post();
        
        
        $is_special=$enterprise->is_special;
        $config = BaseconfigModel::column('data','name');
   
        
        $list['mo_submitted_title']=$config['mo_submitted_title'];
        $lastYear = date('Y', strtotime('-1 year'));
       $list['title']='排污许可登记服务费';
            // 获取今年的年份
        /*$thisYear = date('Y');
        $list['thisyear']=$thisYear;*/
            
        $list['agreement']=$config['mo_tongyi_content'];
       
        
        // 获取去年的年份
        $lastYear = date('Y', strtotime('-1 year'));
        
    
        $list['lastyear']=$lastYear;
        
        
        $data = ['code' =>200,'data'=>$list,'msg' => '获取成功'];
        return json($data);

        
    }
    
    


   

}