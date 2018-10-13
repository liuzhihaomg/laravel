<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>后台首页</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="../backstage/css/font.css">
    <link rel="stylesheet" href="../backstage/css/xadmin.css">
    <link rel="stylesheet" href="{{URL::asset('css/swiper.min.css')}}">
    <script type="text/javascript" src="{{URL::asset('js/jquery-1.9.1.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('js/swiper.jquery.min.js')}}"></script>
    <script src="../backstage/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="../backstage/js/xadmin.js"></script>
</head>
<body>
<!-- 顶部开始 -->
@include("Admin/public/header")
        <!-- 顶部结束 -->
<!-- 中部开始 -->
<div class="wrapper">
    <!-- 左侧菜单开始 -->
    @include("Admin.public.left")
            <!-- 左侧菜单结束 -->
    <!-- 右侧主体开始 -->
    <div class="page-content">
        <form class="layui-form" onsubmit="return false">
            <div class="layui-form-item">
                <label class="layui-form-label">订单编号</label>
                <div class="layui-input-inline" style="width:500px;">
                    <input type="text" name="title" lay-verify="title" autocomplete="off"  class="layui-input" value="{{$order_no}}" readonly id="order_no">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">预付款/元</label>
                    <div class="layui-input-inline">
                        <input type="text" name="number" lay-verify="required|number" autocomplete="off" class="layui-input" placeholder="0" id="order_advance">
                    </div>
                </div>

            </div>
            <div class="layui-inline">
                <label class="layui-form-label">添加日期</label>
                <div class="layui-input-inline">
                    <input type="text" name="date" id="date" lay-verify="date" placeholder="yyyy-MM-dd" autocomplete="off" class="layui-input" value="{{$time}}" readonly>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">联系人</label>
                <div class="layui-input-inline">
                    <select name="interest" lay-filter="aihao" id="order_name">
                        <option value=""></option>
                        <option value="0">王旭</option>
                    </select>
                </div>
            </div>


            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">详情备注</label>
                <div class="layui-input-block">
                    <textarea placeholder="请输入内容" class="layui-textarea" id="order_remark"></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit="" lay-filter="demo1" id="sub">立即提交</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
            <div style="height:400px;">
            </div>
        </form>
    </div>
    <!-- 右侧主体结束 -->
</div>
<!-- 中部结束 -->
<!-- 底部开始 -->
<div class="footer">
    <div class="copyright">Copyright ©2017 x-admin v2.3 All Rights Reserved. 本后台系统由X前端框架提供前端技术支持</div>
</div>
<!-- 底部结束 -->
<!-- 背景切换开始 -->
@include("Admin/public/background")
        <!-- 背景切换结束 -->
{{--<script>--}}
{{--//百度统计可去掉--}}
{{--var _hmt = _hmt || [];--}}
{{--(function() {--}}
{{--var hm = document.createElement("script");--}}
{{--hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";--}}
{{--var s = document.getElementsByTagName("script")[0];--}}
{{--s.parentNode.insertBefore(hm, s);--}}
{{--})();--}}
{{--</script>--}}
</body>
</html>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>

    //提交
    $('#sub').click(function(){

        //获取订单号
        var order_no = $('#order_no').val();
        //获取预付款
        var order_advance = $('#order_advance').val();
        //获取添加订单的日期
        var order_ctime = $('#date').val();
        //获取联系人
        var order_name = $('#order_name').val();
        //获取订单备注
        var order_remark = $('#order_remark').val();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            url:'/order_add_do',
            data:'order_no='+order_no+'&order_advance='+order_advance+'&order_ctime='+order_ctime+'&order_name='+order_name+'&order_remark='+order_remark,
            type:'post',
            dataType:'json',
            success:function(json_info){
                alert(json_info['msg']);
                if(json_info['status'] == 1000){
                    window.location.reload();
                }
            }
        })
    })
</script>
