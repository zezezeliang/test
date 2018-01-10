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
<?php
 if (!Yii::$app->user->isGuest) {
  $name=\Yii::$app->user->identity->username;
      
        }else{
          $name="游客";
        }

?>

  
var ws,name,img,userlist;
ws=new WebSocket("ws://192.168.1.108:1234");

ws.onopen=onopen; 
ws.onmessage=onmessage;
function  onopen(){
   name= "<?php echo $name;?>";
  if(name==""||!name)
  {
    name="游客"
  }
   $("#username").html(name)
    img="<?php echo \Yii::$app->user->identity->headimg; ?>";
   $("#headimg").attr('src',img);
  
  var msg = '{"name":"'+name+'","type":"login","img":"'+img+'"}';
   ws.send(msg);

}

function onmessage(data){
  var msg=JSON.parse(data.data)
  
  for(var i in msg["userlist"])
  {
     $(".user_list li:gt(0)").each(function(){
        var res=$.inArray($(this).attr('data-id'),msg['userlist']['name']);
        if(res>=0){
          // alert($(this).attr('data-id'))
          var color=0;
          var obj=$(this);
           $.ajax({
              url:"index.php?r=hello/gettype&name="+$(this).attr('data-id'),
              type:"post",
              success:function(e){ 
                if(e==1)
                {
                  obj.find('small').attr('class','offline');                 
                }else{
                  obj.find('small').attr('class','online')

                }     
              }
             })
            
          }else{
            $(this).find('small').attr('class','offline')

          }

        

     })
  }


  if(msg['type']=="login"){

    sendMesg("管理员","欢迎用户"+msg['name']+"来到聊天室",msg['time'],"./images/headimg/7.jpg");
  }else if(msg['type']=="logout"){
     sendMesg("管理员","用户"+msg['name']+"离开了聊天室",msg['time'],"./images/headimg/7.jpg");
  }else if(msg['type']=="sendMsg"){
    // alert(name)
     sendMesg(msg['name'],decodeURI(msg['msg']),msg['time'],msg['img']);
  }else if(msg['type']=="sendMsgTo"){
    // alert(name)
     sendMesg(msg['name'],decodeURI(msg['msg']),msg['time'],msg['img']);
  }else if(msg['type']=="sendImage"){
    // alert(name)
     sendMesg(msg['name'],"<img src='"+msg['msg']+"' >",msg['time'],msg['img']);
  }else if(msg['type']=="sendFiles"){
    // alert(decodeURI(msg['msg']))
     sendMesg(msg['name'],decodeURI(msg['msg']),msg['time'],msg['img']);
  }else if(msg['type']=="sendTofriend"){
    msg['msg']=msg['name']+"请求添加您为好友<a href='javascript:void(0);' class='agree' from-id='"+msg['name']+"' >同意并添加</a>";
   
     sendMesg(msg['name'],msg['msg'],msg['time'],msg['img']);
    
  }
  
 

}
function sendMesg( from_name,msg,time,img){
   var htmlData =   '<div class="msg_item fn-clear">'
                   + '   <div class="uface"><img src="'+img+'" width="40" height="40"  alt=""/></div>'
            + '   <div class="item_right">'
            + '     <div class="msg own">' + msg + '</div>'
            + '     <div class="name_time">' + from_name + ' · '+time+'</div>'
            + '   </div>'
            + '</div>';
 $("#message_box").append(htmlData);
 $('#message_box').scrollTop($("#message_box")[0].scrollHeight + 20);
}


</script>

<body>
<div class="chatbox">
  <div class="chat_top fn-clear">
    <div class="logo"><img src="images/logo.png" width="190" height="60"  alt=""/></div>
    <div class="uinfo fn-clear">
      <div class="uface"><img id="headimg" src="images/hetu.jpg" width="40" height="40"  alt=""/></div>
      <div class="uname">
        <span id="username"></span><i class="fontico down"></i>
        <a href="#" id="invisible">隐身</a><a href="javascript:;">开始直播</a>
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
        
     
        
        <div class="msg_item fn-clear">
          <div class="uface"><img src="./images/headimg/7.jpg" width="40" height="40"  alt=""/></div>
          <div class="item_right">
            <div class="msg own">啧啧啧</div>
            <div class="name_time">管理员 · 公告</div>
          </div>
        </div>
      </div>
      <div class="write_box">
        <!-- <textarea id="message" name="message" class="write_area" placeholder="说点啥吧..."></textarea> -->
         <!-- 加载编辑器的容器 -->
      <div><span  ><input type="file" name="f" id="f"><input type="file" name="files" id="files"><a href="index.php?r=hello/lishi">历史消息</a></span></div>
    <script id="container" name="content" type="text/plain"></script>
    <script type="text/javascript">
        var ue = UE.getEditor('container',{toolbars: [
    ['insertimage','edittable','emotion','simpleupload']
    ]});
    </script>


        <input type="hidden" name="fromname" id="fromname" value="<?php echo \Yii::$app->user->identity->username; ?>" />
     
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
        <li class="fn-clear selected"><em id="usernum">所有用户(<?php echo count($list); ?>)</em></li>
      <?php foreach ($list as $key => $value) {
       ?>
      <li class="fn-clear" data-id="<?php echo $value['username'];  ?>"><span><img src="<?php echo $value['headimg'];  ?>" width="30" height="30"  alt=""/></span><em><?php echo $value['username'];  ?></em><small class="offline" title="离线"></small><a href="javascript:void(0)" class="add" >＋</a></li>
      <?php }?>
        <!-- <li class="fn-clear" data-id="1"><span><img src="images/hetu.jpg" width="30" height="30"  alt=""/></span><em>河图</em><small class="online" title="在线"></small></li>
        <li class="fn-clear" data-id="2"><span><img src="images/53f44283a4347.jpg" width="30" height="30"  alt=""/></span><em>猫猫</em><small class="online" title="在线"></small></li>
        <li class="fn-clear" data-id="3"><span><img src="images/53f442834079a.jpg" width="30" height="30"  alt=""/></span><em>白猫</em><small class="offline" title="离线"></small></li> -->
      </ul>
    </div>
  </div>
</div>
<script type="text/javascript">

$(document).ready(function(e) {

  var fromname=$('#fromname').val();
  var to_uid=0;
  var to_uname=0;
  
  $('.user_list > li').dblclick(function(){

      to_uname=$(this).find('em').text();
      // alert(to_uname)
      // alert(fromname)
      to_uid = $(this).attr('data-id');
      if(to_uname == fromname){
          alert('您不能和自己聊天！');
          return false;
      }
      if(to_uname=="所有用户"){
       
        $("#chat_type").text('群聊');
         $("#toname").val("");
      }else{
        $("#toname").val(to_uid);
        $('#chat_type').text('您正在和 ' +to_uname + '聊天');

      }

  })
  
  $('.sub_but').click(function(event){//发送消息

      var ue = UE.getEditor('container');
      var sendMsg = ue.getContent();
      sendMsg=encodeURI(sendMsg);
      var msg;
      if(to_uname&&to_uname!="")
      {
        msg = '{"name":"'+name+'","type":"sendMsgTo","msg":"'+sendMsg+'","img":"'+img+'","toname":"'+to_uname+'"}';
      }else{
        msg = '{"name":"'+name+'","type":"sendMsg","msg":"'+sendMsg+'","img":"'+img+'"}';
      }

      // alert(msg)
      ws.send(msg);
        ue.setContent('');
  });
    $('#invisible').click(function(){//隐身
      $.ajax({
          url:"index.php?r=hello/invisible",
          data:{"name":name},
          dataType:"json",
          type:"post",
          success:function(data){
              if(data==1){

                alert('已经隐身');
                var msg = '{"name":"'+name+'","type":"invisible","img":"'+img+'"}';
                ws.send(msg);
              }
          } 
        })
     })

  $('#f').change(function(){//放送图片
    var csrf = $("input[name='f']").val();
    var formData = new FormData();
    formData.append('f',csrf);
    formData.append('f',$("#f")[0].files[0]);
    // console.log(formData)
    $.ajax({
        url:"index.php?r=hello/upload",
        data:formData,
        contentType:false,
        processData:false,
        dataType:"json",
        type:"post",
        success:function(data){
         msg = '{"name":"'+name+'","type":"sendImage","msg":"'+data+'","img":"'+img+'"}';
        ws.send(msg);
        } 
      })
     })
  $('.add').click(function(){
    var friend = $(this).parent().attr('data-id');
    if(friend==name){
      alert('不能添加自己为好友')
      return false
    }
    // console.log(friend)
    var msg = '{"name":"'+name+'","type":"sendTofriend","toname":"'+friend+'","img":"'+img+'"}';
    ws.send(msg);
    
  });
  // $('.agree').click(function(){
  //   // var fromname = $(this).attr('from-id');
  //   alert(111)
  //   // var msg = '{"name":"'+name+'","type":"sendAgree","toname":"'+fromname+'","img":"'+img+'"}';
  //   // ws.send(msg);
    
  // });
    $('#files').change(function(){//发送文件
    var csrf = $("input[name='files]").val();
    var formData = new FormData();
    formData.append('files',csrf);
    formData.append('files',$("#files")[0].files[0]);
    // console.log(formData)
    $.ajax({
        url:"index.php?r=hello/upfiles",
        data:formData,
        contentType:false,
        processData:false,
        dataType:"json",
        type:"post",
        success:function(data){
        var d ='<a href="'+data+'">'+data+'</a>';
        d=encodeURI(d)
         msg = '{"name":"'+name+'","type":"sendFiles","msg":"'+d+'","img":"'+img+'"}';
        ws.send(msg);
        
        } 


    })


  })


  
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
$(document).on('click','.agree',function(){
  var fromname = $(this).attr('from-id');
    // alert(111)
    var msg = '{"name":"'+name+'","type":"sendAgree","toname":"'+fromname+'","img":"'+img+'"}';
    ws.send(msg);

})
</script>
</body>
</html>
