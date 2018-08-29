ws = new WebSocket("ws://novoland.game:9999");
ws.onopen = function () {
    ws.send(`${uuid}`);
};
ws.onmessage = function (e) {
    var res = eval('(' + e.data + ')');
    var code = res.code, msg = res.msg, data = res.data;
    if (code === 1 || code === '1') {
        console.warn(msg);
        var notice = `<div>
																<span class="layui-badge layui-bg-cyan" style="display: block;text-align: center">${data[0]} 已上线！</span>
															</div>`;
    } else {
        if (code === 2 || code === '2') {
            console.info(msg);
            var notice = `<div>
																		<span class="layui-badge layui-bg-gray" style="display: block;text-align: center">${msg}</span>
																	</div>`;
        } else {
            if (code === 3 || code === '3') {
                var notice =
                    `<div class="layui-row chat-msg" style="color: ${data.color};border: 1px solid #c2c2c2;" uuid="${data.uuid}">
																			<span>${data.time}</span>
																			<div></div>
																			<span class="username">${data.username}：</span>
																			<span>${data.content}</span>
																		</div>`;
            } else {
                var notice = `<div class="layui-row chat-msg" style="color: ${data.color};" uuid="${data.uuid}">
																			<span>${data.time}</span>
																			<div></div>
																			【世界】<span class="username">${data.username}：</span>
																			<span>${data.content}</span>
																		</div>`;
            }
        }
    }
    $(".chat-detail").append(notice);
    var div = document.getElementById('chat-detail');
    div.scrollTop = div.scrollHeight;

};
// 发送消息
$(".chat-send").click(function () {
    sendMsg();
});

// 点击发送给指定用户
$(".chat-detail").on("click", ".chat-msg", function () {
    var uuid = $(this).attr("uuid"), username = $(this).find('.username').text();
    $(".send-content").attr('placeholder', '发送给' + username);
    $(".chat-send").attr("to", uuid);
    $(".to-all").show();
});
$(".to-all").click(function () {
    $(".send-content").removeAttr("placeholder");
    $(".chat-send").attr("to", 0);
    $(this).hide();
});
setInterval(function () {
    ws.send(`heart_beat:${uuid}`);
}, 5000);

/**
 * 发送消息
 */
function sendMsg() {
    var uuid = $(".chat-send").attr("to");
    var rec_id = uuid === 0 || uuid === '0' ? 'all' : uuid;
    var content = $.trim($("textarea").val());
    if (content !== '' && content !== null && content !== undefined) {
        ws.send(`${rec_id}:${content}`);
    }
    $(".send-content").val("").focus();
}