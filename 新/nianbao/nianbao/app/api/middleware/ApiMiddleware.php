<?php
/**
 * +———————————————————————-
 * | Api中间件
 * +———————————————————————-
 */

namespace app\api\middleware;


use think\facade\Request;
use think\Response;
use think\exception\HttpResponseException;

use think\exception\ValidateException;
use app\admin\model\Member as MemberModel;
class ApiMiddleware
{
    public function handle($request, \Closure $next)
    {
        $datas= $request->param();
     
        $strToken = Request::header('token');
        if ($strToken) {
            $member_id = $this->decodeId($strToken);
            if(!$datas['mobile']){
                
            
            
               if (!$member_id) {
                    $data = ['code' => -1, 'msg' => '登录状态已过期，请重新登录'];
                    return json($data);
                }
                
                $where = [];
              
                $where['id']=$member_id;
                $member = MemberModel::where(formatWhere($where))->find();
                $request->member=$member;
    
                $request->member_id = $member_id;
                return $next($request);
                
            }else{
                $member_id = $this->decodeId($strToken);
                $where = [];
                $where['id']=$member_id;
          
                $where['mobile']=$datas['mobile'];
                $member = MemberModel::where(formatWhere($where))->find();
                $request->member=$member;
                $request->member_id = $member_id;
                return $next($request);
            }
            
        } else {
            if($datas['mobile']){

                $where = [];
          
                $where['mobile']=$datas['mobile'];
                $member = MemberModel::where(formatWhere($where))->find();
                $request->member=$member;
                $request->member_id = $member->id;
                return $next($request);
            }else{
                $data = ['code' => -1, 'msg' => '请先登录'];
                return json($data);
            }
            
            
        }
    }
     /**
       * [decodeId ID解密]
       */
     public function decodeId($id = "") {
        //解密
        $id = str_replace("%3D", '=', $id);
        //转码
        $id = $this->ConvertToUTF8(base64_decode($id));
        //截取
        $id = substr($id, 10);
        //返回
        return is_numeric($id) ? $id : 0;
      }
     
     
      /**
       * [ConvertToUTF8 转换为utf-8]
       */
     public function ConvertToUTF8($text){
        //检测
        $encoding = mb_detect_encoding($text, mb_detect_order(), false);
        //判断
        if($encoding == "UTF-8"){
          $text = mb_convert_encoding($text, 'UTF-8', 'UTF-8');   
        }
        //转换
        $out = iconv(mb_detect_encoding($text, mb_detect_order(), false), "UTF-8//IGNORE", $text);
        //返回
        return $out;
      }
}

