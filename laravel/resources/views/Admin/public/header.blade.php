<div class="container">
    <div class="logo"><a href="./index.html">刘成辉的后台</a></div>
    <div class="open-nav"><i class="iconfont">&#xe699;</i></div>
    <ul class="layui-nav right" lay-filter="">
        <li class="layui-nav-item">
            <?php
            $session=session('user_info');
            ?>
            <a href="javascript:;">{{ $session['admin_name']  }}</a>
            <dl class="layui-nav-child"> <!-- 二级菜单 -->
                <dd><a href="">个人信息</a></dd>
                <dd><a href="/quit">切换帐号</a></dd>
                <dd><a href="/quit">退出</a></dd>
            </dl>
        </li>
        <li class="layui-nav-item"><a href="/admin">前台首页</a></li>
    </ul>
</div>