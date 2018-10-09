<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class AdministratorController extends CommonController
{
    /***
     * 管理员的添加视图页面
     */
    public function administrator_add(){
        $user_info=$this->sessioninfo();
        $new_node=$this->judge_admin($user_info['admin_id']);
        $crm_admin_role_data=DB::table('crm_admin_role')->get()->toArray();
        $crm_admin_role_data=json_decode(json_encode($crm_admin_role_data),true);
        return view('Admin.administrator.administrator_add',['new_node'=>$new_node,'crm_admin_role_data'=>$crm_admin_role_data]);
    }

    /***
     * 管理员的添加
     */
    public function administrator_do(){
        $input=Input::all();
        $str=rtrim($input['str'],',');
        $arr=explode(',',$str);
        DB::beginTransaction();
        $insert=[];
        $insert['admin_name']=$input['admin_name'];
        $insert['admin_psd']=md5($input['admin_psd']);
        $insert['real_name']=$input['real_name'];
        $insert['phone']=$input['phone'];
        $insert['remarks']=$input['textarea'];
        $insert['ctime']=time();
        $insert['status']=1;
        $insert_id=DB::table('crm_admin')->insertGetId($insert);
        if(!empty($insert_id)) {
            $data = [];
            foreach ($arr as $k => $v) {
                $data[$k]['admin_id'] = $insert_id;
                $data[$k]['role_id'] = $v;
            }
        }
        $role_data=array_values($data);
        $res=DB::table('crm_admin_role_relation')->insert($role_data);
        if($insert_id && $res){
            DB::commit();
            return $this->success('管理员注册成功');
        }else{
            DB::rollBack();
            return $this->fail('管理员注册失败');
        }

    }

    /***
     * 管理员的展示
     */
    public function administrator_list(){
        $user_info=$this->sessioninfo();
        $new_node=$this->judge_admin($user_info['admin_id']);
        //查询用户数据
        $crm_admin_data=DB::table('crm_admin')->get()->toArray();
        $crm_admin_data=json_decode(json_encode($crm_admin_data),true);
        //查询条数
        $crm_admin_count=DB::table('crm_admin')->count();
        return view('Admin.administrator.administrator_list',['new_node'=>$new_node,'crm_admin_data'=>$crm_admin_data,'crm_admin_count'=>$crm_admin_count]);
    }

    /***
     * 用户的删除
     */
    public function administrator_del(){
        $input=Input::all();
        $res=DB::table('crm_admin')->where(['admin_id'=>$input['id']])->delete();
    }
}
