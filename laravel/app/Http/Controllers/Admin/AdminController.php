<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin;

class AdminController extends CommonController
{
    /***
     * 后台首页
     */
    public function admin(){
        $user_info=$this->sessioninfo();
        if(!$user_info){
            header("refresh:2;url=/login");
            echo "<span style='color:red'> 请先登录 </span>";
          exit;
        }
        $new_node=$this->judge_admin($user_info['admin_id']);
        return view('Admin.admin.admin',['new_node'=>$new_node]);
    }
	
	//测试
	public function adminlogin(){
		echo   2222222;
	}
}
