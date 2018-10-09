<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>后台登录</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="../backstage/css/font.css">
    <link rel="stylesheet" href="../backstage/css/xadmin.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/Swiper/3.4.2/css/swiper.min.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/Swiper/3.4.2/js/swiper.jquery.min.js"></script>
    <script src="../backstage/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="../backstage/js/xadmin.js"></script>

</head>
<body>
<div class="login-logo"><h1>X-ADMIN V1.1</h1></div>
<div class="login-box">
    <form class="layui-form layui-form-pane" action="">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <h3>登录你的帐号</h3>
        <label class="login-title" for="username">帐号</label>
        <div class="layui-form-item">
            <label class="layui-form-label login-form"><i class="iconfont">&#xe6b8;</i></label>
            <div class="layui-input-inline login-inline">
                <input type="text" name="username" lay-verify="required" placeholder="请输入你的帐号" autocomplete="off" class="layui-input">
            </div>
        </div>
        <label class="login-title" for="password">密码</label>
        <div class="layui-form-item">
            <label class="layui-form-label login-form"><i class="iconfont">&#xe82b;</i></label>
            <div class="layui-input-inline login-inline">
                <input type="password" name="password" lay-verify="required" placeholder="请输入你的密码" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="form-actions">
            <button class="btn btn-warning pull-right" lay-submit lay-filter="login"  type="button">登录</button>
            <div class="forgot"><a href="#" class="forgot">忘记帐号或者密码</a></div>
        </div>
    </form>
</div>
<!-- 背景切换开始 -->
@include("Admin/public/background")
<script>
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}})
    $(function  () {
        layui.use('form', function(){
            var form = layui.form();
            //监听提交
            form.on('submit(login)', function(data){
                //ajax发送数据进行添加权限
                $.ajax({
                    //请求的路径
                    url: "login_do",//你的路由地址url :‘/register_phone’
                    //数据传输
                    data: data.field,
                    //请求方式
                    type: 'post',
                    //返回数据类型  json|html|xml
                    dataType: 'json',
                    //回调方法
                    success: function (info) {
                        if(info.status==1000){
                            layer.msg(info.msg,{time:2000},function(){
                                location.href="admin";
                            })

                        }else{
                            layer.msg(info.msg,{time:2000})
                        }
                    }
                })
            });
        });
    })

</script>
</body>
</html>