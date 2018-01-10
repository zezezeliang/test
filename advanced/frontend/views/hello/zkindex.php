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
    width: 600px;
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
.content .chat{
    margin-top: 50px;
    margin-left: 50px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
    padding: 10px 10px;
}

.content .user{
    text-align: left;
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

.content .service{
    text-align: right;

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

.content .input-message{
    margin-left: 50px;
}

.content textarea{
    margin-top: 20px;
    width: 100%;
    height: 100px;
    border: 1px solid #ddd;
    padding: 5px 10px;
}

.content .submit{
    width: 150px;
    height: 35px;
    line-height: 35px;
    border-radius: 3px;
    border: 1px solid #ddd;
    display: block;
    background: rgba(14, 196, 210, 0.99);
    color: #fff;
    text-align: center;
    margin: 5px auto;
}

</style>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript">
    var ws;
    ws=new WebSocket("ws://192.168.1.108:1234");
    ws.onopen=onopen;
    ws.onmessage=onmessage;
    function onmessage(data){

        if(msg['type']=="say"){

            
        }
    }
   
</script>

<div class="top">
    <ul class="">
        <li><a class="nav" href="#">商品列表</a></li>
        <li><a class="nav" href="#">用户中心</a></li>
        <li><a class="nav selected" href="#">我的客服</a></li>
    </ul>
    <div class="login_register">
        <a href="./login.html">登录</a>
        |
        <a href="./register.html">注册</a>
    </div>
</div>

<div class="content">
    <div class="chat">
        <p class="user">
            <span class="name">客服：</span><br>
            <span class="message">您好，请问有什么可以帮助您的？</span>
        </p>
        <p class="service">
            <span class="name">用户昵称（例：二哈）：</span><br>
            <span class="message">我想咨询一下关于销售业绩提成的相关内容</span>      
        </p>
    </div>
    <div class="input-message">
        <form action="">
            <textarea name="" id="con" cols="30" rows="10"></textarea>
            <a href="javascript:;" class="submit">提交</a>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).on('click','.submit',function(){

        var con = $("#con").html();
        alert(con)
        
    })
</script>