<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>聊天室 - editor:yinq</title>
<link rel="shortcut icon" href="favicon.png">
<link rel="icon" href="favicon.png" type="image/x-icon">
<link type="text/css" rel="stylesheet" href="css/style.css">
<script type="text/javascript" src="js/jquery.min.js"></script>
</head>

    <!-- 配置文件 -->
    <script type="text/javascript" src="ueditor/utf8-php/ueditor.config.js"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="ueditor/utf8-php/ueditor.all.js"></script>
    <!-- 实例化编辑器 -->
<script type="text/javascript">


  


</script>

<body>
<div class="chatbox">
  <div class="chat_top fn-clear">
    <div class="logo"><img src="images/logo.png" width="190" height="60"  alt=""/></div>
    <div class="uinfo fn-clear">
      <div class="uface"><img id="headimg" src="images/hetu.jpg" width="40" height="40"  alt=""/></div>
      <div class="uname">
        <span id="username"></span><i class="fontico down"></i>
        <ul class="managerbox">
          <li><a href="#"><i class="fontico lock"></i>修改密码</a></li>
          <li><a href="#"><i class="fontico logout"></i>退出登录</a></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="chat_message fn-clear">
    <div class="chat_left">
      <div class="message_box" id="message_box">
        <div class="msg_item fn-clear">
          <div class="uface"><img src="images/53f44283a4347.jpg" width="40" height="40"  alt=""/></div>
          <div class="item_right">
            <div class="msg">近日，TIOBE发布了2014年9月的编程语言排行榜，Java、C++跌至历史最低点，前三名则没有变化，依旧是C、Java、Objective-C。</div>
            <div class="name_time">猫猫 · 3分钟前</div>
          </div>
        </div>
        
     
        <?php foreach($arr as $key => $v){ ?>
        <div class="msg_item fn-clear">
          <div class="uface"><img src="./images/headimg/7.jpg" width="40" height="40"  alt=""/></div>
          <div class="item_right">
            <div class="msg own"><?php echo urldecode($v['connect']); ?></div>
            <div class="name_time"><?php echo $v['name']; ?> · <?php echo $v['time']; ?></div>
          </div>
        </div>
      </div>
      <?php } ?>
      <div class="write_box">
        <!-- <textarea id="message" name="message" class="write_area" placeholder="说点啥吧..."></textarea> -->
         <!-- 加载编辑器的容器 -->
      <div><span  ><a href="index.php?r=hello/lishi">历史消息</a></span></div>
    <script id="container" name="content" type="text/plain"></script>
    <script type="text/javascript">
        var ue = UE.getEditor('container',{toolbars: [
    ['insertimage','edittable','emotion','simpleupload']
    ]});
    </script>


        <input type="hidden" name="fromname" id="fromname" value="河图" />
        <input type="hidden" name="to_uid" id="to_uid" value="0">
        <div class="facebox fn-clear">
          <div class="expression"></div>
          <div class="chat_type" id="chat_type">群聊</div>
          <button name="" class="sub_but">提 交</button>
        </div>
      </div>
    </div>
    <div class="chat_right">
      <ul class="user_list" title="双击用户私聊">
        
        <!-- <li class="fn-clear" data-id="1"><span><img src="images/hetu.jpg" width="30" height="30"  alt=""/></span><em>河图</em><small class="online" title="在线"></small></li>
        <li class="fn-clear" data-id="2"><span><img src="images/53f44283a4347.jpg" width="30" height="30"  alt=""/></span><em>猫猫</em><small class="online" title="在线"></small></li>
        <li class="fn-clear" data-id="3"><span><img src="images/53f442834079a.jpg" width="30" height="30"  alt=""/></span><em>白猫</em><small class="offline" title="离线"></small></li> -->
      </ul>
    </div>
  </div>
</div>
<script type="text/javascript">

$(document).ready(function(e) {
  
  
  
  $('.sub_but').click(function(event){

      var ue = UE.getEditor('container');
      var sendMsg = ue.getContent();
      sendMsg=encodeURI(sendMsg);
      // alert(sendMsg)
      var msg = '{"name":"'+name+'","type":"sendMsg","msg":"'+sendMsg+'","img":"'+img+'"}';

      // alert(msg)
      ws.send(msg);
        ue.setContent('');
  });


  
 });
function sendMessage(event, from_name, to_uid, to_uname){
    var msg = $("#message").val();
  if(to_uname != ''){
      msg = '您对 ' + to_uname + ' 说： ' + msg;
  }
  var htmlData =   '<div class="msg_item fn-clear">'
                   + '   <div class="uface"><img src="images/hetu.jpg" width="40" height="40"  alt=""/></div>'
             + '   <div class="item_right">'
             + '     <div class="msg own">' + msg + '</div>'
             + '     <div class="name_time">' + from_name + ' · 30秒前</div>'
             + '   </div>'
             + '</div>';
  $("#message_box").append(htmlData);
  $('#message_box').scrollTop($("#message_box")[0].scrollHeight + 20);
  $("#message").val('');
}
</script>
</body>
</html>
