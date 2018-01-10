<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>直播间</title>
</head>

<body>
	<div style="width: 400px;height:300px; border: 3px;background-color:#666;" ><center style="padding-top: 120px"><h1>直播间</h1></center></div>
	<hr/>
	<p  ><h3 id="liwua">礼物</h3></p>
	<div style="width: 120px;height: 50px;display: none;background-color:#999;" id="doliwu" ><span ><b class="lw" fen="5">花</b>&nbsp;&nbsp;</span><span><b class="lw" fen="10">掌声</b>&nbsp;&nbsp;</span><span><b class="lw" fen="20">豪车</b></span></div>

<hr/>
<h1>讨论区</h1>
<?php 

header('content-type:text/html; charset=utf8');
setcookie('name','姚辉');
setcookie('img','./2.jpg');


?>

<hr>
<div id="liao">

</div>
<hr>
<textarea id="count" rows="10" cols="20"></textarea><button id="sub">提交</button>
<button id="biaoqing">表情</button>
<div id="qing" style="display: none;" >
	<img style="height: 50px; width: 100px;" value="[嘻嘻]" src="./2.jpg" class="biao" >
	<img style="height: 50px; width: 100px;" value="[呵呵]" src="./1.jpg" class="biao" >

	

	

</div>
</body>
</html>
<script type="text/javascript" src="js/jquery.min.js" ></script>
<script type="text/javascript">
$(document).on('click','#liwua',function(){
	// alert(1)
	$('#doliwu').css('display','block')
})
$(document).on('click','#biaoqing',function(){
	$('#qing').css('display','block')
})
$(document).on('click','.biao',function(){

	var img = $(this).attr('value');
	var content=$('#count').val();
	var content=$('#count').val(img+content)
	$('#qing').css('display','none')



})
$(document).on('click','.lw',function(){
	var fen =$(this).attr('fen');
	var str='<ul>\
	<li>                                 <span>您打赏了主播一个'+fen+'分的礼物</span>                       <span><b>日期</b>刚刚</span></li>\
	<li>礼物</li>\
</ul>';
		// alert(str)
		$('#liao').append(str)
		$('#doliwu').css('display','none')
})


	
$(document).on('click','#sub',function(){
	
	var content=$('#count').val()

	$.ajax({

		url:"index.php?r=hello/domsg",
		data:"content="+content,
		dataType:"json",
		type:"post",
		success:function(msg){
			// alert(msg)
			var a=msg.content;
			a=a.replace("[嘻嘻]",'<img style="height: 50px; width: 100px;" value="[嘻嘻]" src="./2.jpg" class="biao" >');
			a=a.replace("[呵呵]",'<img style="height: 50px; width: 100px;" value="[呵呵]" src="./3.jpg" class="biao" >');

			// alert(a)
			var str='<ul>\
		<li><img style="height: 50px; width: 100px;" src="'+msg.img+'"  >                                   <span>'+a+'</span>                       <span><b>日期</b>'+msg.time+'</span></li>\
		<li>'+msg.name+'</li>\
	</ul>';
			// alert(str)
			$('#liao').append(str)
			$('#count').val("")

			// console.log(msg)
		}

	})


})


</script>