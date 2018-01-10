<meta charset="utf8">

<style>

*{margin: 0; padding:0 ; font-family: 微软雅黑}
a{ text-decoration: none; color: #666;}
ul{ list-style: none}

body{ color: #333}
.top{ 
    border-bottom: 1px solid #ddd; 
    height: 100px; 
    width: 100%;
    padding: 1px;
}
.top ul{
    display: flex;
    width: 400px;
    margin: 0 auto;
    margin-top: 20px;
}
.top .nav{ display: inline-block; width: 200px; height: 45px; text-align: center; line-height: 45px}
.top .selected{ color: #fff; background: rgba(59, 164, 196, 0.98);}
.top .login_register{ text-align: right; margin-right: 10px;}

.content{
    width: 1024px;
    margin: 0 auto;
    font-size: 14px;
}

.content .user-content-list{
    margin-top: 50px;
}

.content .user-content-list li{
    border-bottom: 1px solid #ddd;
    width: 150px;
    text-align: center;
    height: 40px;
    line-height: 40px;
}

.content .user-content-list li a{
    font-size: 16px;
}

.content .user-content{

    display: flex;
    justify-content: space-between;
}

.content .user-content .selected{
    color: rgba(59, 164, 196, 0.98);
}

.content .line{
    width: 1px;
    border-left: 1px solid #ddd;
    height: 100%;
}

.content .right{
    width: 800px;
}

.content .right .my_team{
    display: flex;
}

.content .right .my_team_list{
    border:1px solid #ddd;
    width: 200px;
    height: 500px;
    margin-top: 50px;
}

.content .right .my_team_list ul li{
    height: 40px;
    line-height: 40px;
    border-bottom: 1px solid #ddd;
    text-align: center;
    color: #808080;
}

.content .my_team_chat{
    border: 1px solid #ddd;
    border-left: none;
    margin-top: 50px;
    height: 500px;
    width: 600px;
}

.content .my_team_chat .submit{
    width: 150px;
    height: 35px;
    line-height: 35px;
    border-radius: 3px;
    border: 1px solid #ddd;
    display: block;
    background: rgba(14, 196, 210, 0.99);
    color: #fff;
    text-align: center;
    float: right;
}

.content .my_team_chat .chat{
    width: 100%;
    height: 365px;
}

.content .my_team_chat .chat{

    overflow-y: scroll;
}

.content .my_team_chat .chat p{
    margin-top: 10px;
}

.content .user{
    text-align: left;
    margin-left: 10px;
}

.content .name{
    color: rgba(14, 196, 210, 0.99);
}

.content .user .message{
    display: inline-block;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 5px 10px;
    margin-top: 10px;
    background: #ddd;
}

.content .my_team_chat textarea{
    border: none;
    border-top: 1px solid #ddd;
    width: 100%;
    height: 100px;
}

.content .service{
    text-align: right;
    margin-right: 10px;
}

.content .service .message{
    display: inline-block;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 5px 10px;
    margin-top: 10px;
    text-align: left;
    background: #ddd;
}

</style>
<?php
    $name=\Yii::$app->user->identity->username;

?>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript">
    var ws,name;


    name="<?php echo $name; ?>";
    ws=new WebSocket("ws://192.168.1.108:2221");
    // ws.onopen=onopen;
    ws.onmessage=onmessage;
    function onmessage(data){
        
        var msg=JSON.parse(data.data)
 
        if(msg["type"]=="Service"){
            
                // alert(1)
                return false;
            
        }else{
            // alert(2)
               $(".chat").append('<p class="user">\
                            <span class="name">'+msg["name"]+'：</span><br>\
                            <span class="message">'+msg["msg"]+'</span>\
                        </p>') 
        }
        
    }
    
</script>

<div class="top">
    <ul class="">
        <li><a class="nav" href="./index.html">商品列表</a></li>
        <li><a class="nav selected" href="#">用户中心</a></li>
    </ul>
    <div class="login_register">
        <a href="./login.html">登录</a>
        |
        <a href="./register.html">注册</a>
    </div>
</div>

<div class="content">
    <div class="user-content">
        <ul class="user-content-list">
            <li><a href="#">我的返现</a></li>
            <li><a href="#">我的邀请链接</a></li>
            <li><a class="selected" href="#">我的团队</a></li>
        </ul>
        <div class="line"></div>
        <div class="right">
            <div class="my_team">
                <div class="my_team_list">
                    <ul>
                    <?php foreach ($data as $key => $val) {
                     ?>
                        <li><?php echo $val['username'];  ?></li>
                        
                     <?php } ?>
                    </ul>
                </div>
                <div class="my_team_chat">
                    <div class="chat">
                        
                       
                    </div>
                    <textarea name="" id="aaa" cols="30" rows="10"></textarea>
                    <a href="javascript:;" class="submit">提交</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).on('click','.submit',function(){

        var msg= $("#aaa").val();
        // alert(name)
        if(name=="admin"){
            var data = '{"type":"Service","msg":"'+msg+'"}';
        }else{
            var data = '{"type":"User","name":"'+name+'","msg":"'+msg+'"}';
        }
        // alert(data)
        ws.send(data);

        $("#aaa").val("");
        
    })
</script>