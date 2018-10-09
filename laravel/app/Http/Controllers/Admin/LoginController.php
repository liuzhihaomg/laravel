<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\session;

class LoginController extends CommonController
{
    /***
     * 后台首页
     */
    public function login()
    {
        return view('Admin.login.login');
    }

    /***
     * 执行登录
     */
    public function login_do()
    {
        $input = Input::all();
        $data=(array)DB::table('crm_admin')->where(['admin_name'=>$input['username']])->first();
        if(!empty($data)){
            $password=md5($input['password']);
            if($password!=$data['admin_psd']){
                return $this->fail('账号或密码错误，请核对！');
            }else{
                Session(['user_info'=>$data]);
                return $this->success('登录成功');
            }
        }else{
            return $this->fail('账号或密码错误，请核对！');
        }
    }

    /***
     * 退出
     */
    public function quit(){
        Session::forget('user_info');
        $user_info=$this->sessioninfo();
        if(!$user_info){
            header("refresh:2;url=/login");
            echo "<span style='color:red'> 退出成功 </span>";
            exit;
        }
    }
}