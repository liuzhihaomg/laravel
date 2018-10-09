<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>客户添加</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="backstage/css/font.css">
    <link rel="stylesheet" href="backstage/css/xadmin.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/Swiper/3.4.2/css/swiper.min.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/Swiper/3.4.2/js/swiper.jquery.min.js"></script>
    <script src="backstage/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="backstage/js//xadmin.js"></script>

</head>
<body>
<!-- 顶部开始 -->
@include("Admin/public/header")
        <!-- 顶部结束 -->
<!-- 中部开始 -->
<div class="wrapper">
    <!-- 左侧菜单开始 -->
    @include("Admin/public/left")
            <!-- 左侧菜单结束 -->
    <!-- 右侧主体开始 -->
    <div class="page-content">
        <div class="content">
            <!-- 右侧内容框架，更改从这里开始 -->
            <div class="layui-form">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">客户姓名</label>
                        <div class="layui-input-inline">
                            <input type="text" name="user_name" lay-verify="text" placeholder="请输入客户的名字" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                </div>

                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">手机号</label>
                        <div class="layui-input-inline">
                            <input type="text" name="user_phone" lay-verify="required|number"placeholder="请输入客户的手机号" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">邮编</label>
                    <div class="layui-input-inline">
                        <input type="text" name="user_postcode" lay-verify="pass" placeholder="请输入邮编" autocomplete="off" class="layui-input">
                    </div>
                </div>


                <div class="layui-form-item">
                    <label class="layui-form-label">客户所在地</label>
                    <div class="layui-input-inline">
                        <select lay-filter="test" chage='1' class = "select11" name="province">
                            <option value="">请选择</option>
                            @foreach($province_list as $value)
                            <option value="{{$value['id']}}">{{$value['area_name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="layui-input-inline">
                        <select lay-filter="test" chage='2' class = "select" name="city">
                            <option value="">请选择</option>
                        </select>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">客户的详细地址</label>
                    <div class="layui-input-inline">
                        <input type="text" name="user_address" lay-verify="pass" placeholder="客户的详细地址" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">客户类型</label>
                    <div class="layui-input-inline">
                        <select  name="user_type">
                            <option value="">请选择</option>
                            @foreach($type as $v)
                            <option value="{{$v['type_id']}}">{{$v['type_name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">客户来源</label>
                    <div class="layui-input-inline">
                        <select  name="user_source">
                            <option value="">请选择</option>
                            @foreach($source as $v)
                                <option value="{{$v['source_id']}}">{{$v['source_name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">客户备注</label>
                    <div class="layui-input-block">
                        <textarea placeholder="请输入内容" class="layui-textarea" name="remark"></textarea>
                    </div>
                </div>

                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" type="button" lay-filter="demo1">立即提交</button>
                        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                    </div>
                </div>
            </div>
            <!-- 右侧内容框架，更改从这里结束 -->
        </div>
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
</body>
</html>

<script>
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

    $('.layui-btn').click(function(){
        var user_name=$('[name=user_name]').val();
        if(user_name==''){
            layer.msg('客户名不能为空',{time:2000});
            return false;
        }

        var name = $("[name=user_name]").val();
        var obj = /^[\u4E00-\u9FA5]{2,4}$/;
        if(obj.test(name)){
        }else{
            alert('请输入正确的客户名称');
            return false;
        }

        var user_phone=$('[name=user_phone]').val();
        if(user_phone==''){
            layer.msg('客户手机号不能为空',{time:2000});
            return false;
        }

        var str = $("[name=user_phone]").val();
        var ret = /^1[\d]{10}$/;
        if(ret.test(str)){
        }else{
            alert('请输入正确的手机号');
            return false;
        }

        var user_postcode=$('[name=user_postcode]').val();
        if(user_postcode==''){
            layer.msg('客户邮编不能为空',{time:2000});
            return false;
        }

        var province=$('[name=province]').val();
        if(province==''){
            layer.msg('请选择客户所在省',{time:2000});
            return false;
        }

        var city=$('[name=city]').val();
        if(city==''){
            layer.msg('请选择客户所在市',{time:2000});
            return false;
        }

        var user_address=$('[name=user_address]').val();
        if(user_address==''){
            layer.msg('客户详细地址不能为空',{time:2000});
            return false;
        }

        var user_type=$('[name=user_type]').val();
        if(user_type==''){
            layer.msg('请选择客户类型',{time:2000});
            return false;
        }

        var user_source=$("[name=user_source]").val();
        if(user_source==''){
            layer.msg('请选择客户类型',{time:2000});
            return false;
        }

        var user_remark=$('[name=remark]').val();
        if(user_remark==''){
            layer.msg('请填写客户的备注',{time:2000});
            return false;
        }

        //ajax发送数据进行添加权限
        $.ajax({
            url: "user_add_do",//你的路由地址url :‘/register_phone’
            data: 'user_name='+user_name+'&user_phone='+user_phone+'&user_postcode='+user_postcode+'&user_province='+province+'&user_city='+city+'&user_address='+user_address+'&user_type='+user_type+'&user_source='+user_source+'&user_remark='+user_remark,//数据传输
            type: 'post',//请求方式
            dataType: 'json',
            success: function (info) {
                if(info.status==1000){
                    layer.msg(info.msg);
                }else{
                    layer.msg(info.msg);
                }
            }
        })

    });

    layui.use('form', function(){
        var form = layui.form();
        console.log($(this));
        form.on('select(test)', function(data){
            var select = data.elem.classList[0];
            var signs = 2;
            if(select=='select11'){
                signs=1;
            }
            var type='';
            if( signs == 1 ){
                var type = 1;
                var id = data.value;
            }else{
                var type =2;
                var id = data.value;
            }

            $.ajax({
                url:"user_address",
                type:'post',
                dataType:'json',
                data:'id='+id+'&type='+type,
                success:function( json_data ){
                    var option_str ='<option>请选择</option>';
                    $.each(json_data.data,function(k , v){
                        console.log(k,v);
                        option_str += '<option value="'+v.id+'">'+ v.area_name+'</option>';
                    });
                    if( type == 1 ){
                        console.log(111111);
                        $('[name=city]').html(option_str);
                        $('[name=area]').html('<option>请选择</option>');
                    }else{
                        console.log(222222);
                        $('[name=area]').html(option_str);
                    }
                    form.render();
                }
            })
        });
    });
</script>