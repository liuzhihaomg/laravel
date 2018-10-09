<?php
/**
 * Created by PhpStorm.
 * User: 刘成辉
 * Date: 2018/9/8
 * Time: 10:36
 */
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\View\View;
class CommonController extends Controller
{
    public function judge_admin ($admin_id){
        if(!empty($admin_id)){
            if($admin_id ==1){
                return $this->construct();
            }else{
                $array=$this->_getAdminpower($admin_id);
                $new_power=[];
                foreach($array as $k=>$v){
                    $new_power[]=$v['url'];
                    foreach($v['son'] as $kk=>$vv){
                        $new_power[]=$vv['url'];
                    }
                }
                array_push($new_power,"/admin");
                $path=request()->path();
                $path_ing='/'.$path;
                if(!in_array($path_ing,$new_power )){
                    exit('没有权限');
                }
                return $array;
            }

        }else{
           return $this->gologin('请先登录');
        }
    }

    /***
     * 左侧菜单列表
     */
    public function construct(){
        $power_node_data=DB::table('crm_power_node')->where(['status'=>1])->get()->toArray();
        $power_node_data=json_decode(json_encode($power_node_data),true);
        if(!empty($power_node_data)){
            $new_node=[];
            foreach($power_node_data as $key=>$value){
                if($value['parent_id']==0){
                    $new_node[$value['id']]=$value;
                }else{
                    $new_node[$value['parent_id']]['son'][]=$value;
                }
            }
        }
        return $new_node;
    }

    /***
     * 查询权限
     */
    public function _getAdminpower($admin_id){
        $sql="select * from `crm_admin`
LEFT JOIN `crm_admin_role_relation` ON crm_admin.admin_id=crm_admin_role_relation.admin_id
        LEFT JOIN `crm_admin_role` ON crm_admin_role.id=crm_admin_role_relation.role_id
LEFT JOIN `crm_role_node`ON crm_role_node.role_id=crm_admin_role_relation.role_id
        LEFT JOIN crm_power_node ON crm_power_node.id=crm_role_node.node_id
where crm_admin.admin_id=$admin_id";
        $node_list=DB::select($sql);
        $node_list=json_decode(json_encode($node_list),true);
        $new_node=[];
    if(!empty($node_list)){
        foreach($node_list as $key=>$value){
            if($value['parent_id']==0){
                $new_node[$value['id']]=$value;
            }else{
               $new_node[$value['parent_id']]['son'][]=$value;
            }
        }
    }
        return $new_node;
    }

    /**
     * 正确提示
     * @param type $error_msg
     */
    function success( $error_msg = 'ok', $data=[]){
        return [
            'status' => 1000 ,
            'msg' => $error_msg,
            'data'=>$data
        ];

    }

    /**
     * 错误提示
     * @param type $error_msg 提示信息
     */
    function fail( $error_msg ){
        return [
            'status' => 1 ,
            'msg' => $error_msg
        ];
    }

    /**
     * 跳回登录页面
     * @param type $error_msg 提示信息
     */
    function gologin( $error_msg ){
        return [
            'status' =>99,
            'msg' => $error_msg
        ];
    }

    //生成4位随机数
    function createmath( $num ){
        $str="abcdefghijklmnopqrstuvwxyz0123456789";
        $len= mb_strlen($str ,'utf8');
        $link="";
        while ( $num ) {
            $rd = rand( 0, $len-1 );
            $link .=mb_substr($str, $rd , 1 ,'utf8');
            $num--;
        }
        return $link;
    }

    /***
     * 判断用户是否登录
     */
    public function sessioninfo(){
        if($session=session('user_info')){
            return $session;
        }else{
            return [];
        }
    }

}