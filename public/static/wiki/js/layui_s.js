layui.use('element', function () {
    var element = layui.element;

    //一些事件监听
    // element.on('tab(demo)', function(data){
    //     console.log(data);
    // });
});

layui.use('form', function () {
    var form = layui.form;

    //各种基于事件的操作
});

layui.use('layer', function () {
    var layer = layui.layer;
    $(function () {
        $(".logout").click(function () {
            layer.confirm("确定要离开了吗？", {icon: 3, title: ''}, function (index) {
                layer.close(index);
                layer.msg("所谓弃族的命运<br>就是要穿越荒原<br>再次竖起战旗<br>返回故乡<br>死不可怕<br>只是一场长眠", {time: 8000});
                setTimeout(function () {
                    window.location.href = logout;
                }, 5500);
            });
        });
    });
    ws.onerror = function () {
        layer.confirm('谷玄星干扰了你和九州之间的连接，是否需要立即恢复？', {
            icon: 3,
            title: ''
        }, function (index) {
            layer.close(index);
            layer.msg('正在重新连接到九州，请稍后……');
            window.location.reload();
        });
    };
    ws.onclose = function () {
        layer.confirm('谷玄星干扰了你和九州之间的连接，是否需要立即恢复？', {
            icon: 3,
            title: ''
        }, function (index) {
            layer.close(index);
            layer.msg('正在重新连接到九州，请稍后……');
            window.location.reload();
        });
    };
});