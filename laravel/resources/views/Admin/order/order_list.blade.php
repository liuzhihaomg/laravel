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
    @csrf
    <table class="layui-table" lay-data="{height:315, url:'/demo/table/user/', page:true, id:'test'}" lay-filter="test">
        <thead>
        <tr>
            <th lay-data="{field:'id', width:80, sort: true}">ID</th>
            <th lay-data="{field:'username', width:80}">订单号</th>
            <th lay-data="{field:'sex', width:80, sort: true}">联系人</th>
            <th lay-data="{field:'city'}">预付款</th>
            <th lay-data="{field:'sign'}">添加日期</th>
            <th lay-data="{field:'experience', sort: true}">详情备注</th>
            <th lay-data="{field:'experience', sort: true}">操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($order_list  as $val)
            <tr>
                <td>{{$val['order_id']}}</td>
                <td>{{$val['order_no']}}</td>
                <td>{{$val['order_name']}}</td>
                <td>{{$val['order_advance']}}</td>
                <td>{{$val['order_ctime']}}</td>
                <td>{{$val['order_remark']}}</td>
                <td><a href="#" class="delete" id="{{$val['order_id']}}">删除</a>
                    <a href="/order_update" class="update" id="{{$val['order_id']}}">修改</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div style="height:600px;"></div>
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
<script>
    layui.use('table', function(){
        var table = layui.table;

        //第一个实例
        table.render({
            elem: '#demo'
            ,height: 312
            ,url: '/demo/table/user/' //数据接口
            ,page: true //开启分页
            ,cols: [[ //表头
                {field: 'id', title: 'ID', width:80, sort: true, fixed: 'left'}
                ,{field: 'username', title: '用户名', width:80}
                ,{field: 'sex', title: '性别', width:80, sort: true}
                ,{field: 'city', title: '城市', width:80}
                ,{field: 'sign', title: '签名', width: 177}
                ,{field: 'experience', title: '积分', width: 80, sort: true}
                ,{field: 'score', title: '评分', width: 80, sort: true}
                ,{field: 'classify', title: '职业', width: 80}
                ,{field: 'wealth', title: '财富', width: 135, sort: true}
            ]]
        });

    });
</script>
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

    //删除
    $('.delete').click(function(){
        //csrf
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        var token = $("[name='_token']").val();
        //获取当前要删除的id
        var order_id = $(this).attr('id');
//        $.ajax({
//            url:'/order_delete',
//            data:'order_id='+order_id+"&_token="+token,
//            type:'post',
//            dataType:'json',
//            success:function(json_info){
//                alert(json_info.msg);
//                window.location.reload();
//
//            }
//        })
        $.post('/order_delete',{
            order_id:order_id,
            _token:token
        },function(data){
            alert(data.msg);
                window.location.reload();
        })
    })

    //修改
    /*$('.update').click(function(){
        //获取要修改的id
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        var order_id = $(this).attr('id');
        alert(123);
        $.ajax({
            url:'/order_update',
            data:'order_id='+order_id,
            type:'post',
            dataType:'json',
            success:function(json_info){
                alert(json_info);
            }
        })
    })*/
</script>
