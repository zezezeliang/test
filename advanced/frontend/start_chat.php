<?php
use Workerman\Worker;
require_once '../Workerman/Autoloader.php';

$http_worker = new Worker("websocket://0.0.0.0:1234");
// $live=new Worker("websocket://0.0.0.0:2354");

$http_worker->count = 4;
$http_worker->name="chat";
// ¿¿4¿¿¿¿¿¿¿¿¿


// ¿¿¿¿¿¿¿¿¿¿¿¿¿¿hello world¿¿¿¿
$http_worker->onConnect = "onConnect";
$http_worker->onMessage = "onMessage";
$http_worker->onClose = "onClose";


function onConnect($connection)
{	
	echo "id:".$connection->id."``````";
	echo "ip:".$connection->getRemoteIp()."\n";
    // ¿¿¿¿¿¿hello world
    
}
function onMessage($connection,$data){
	
    global $http_worker;
 	$pdo=new PDO('mysql:host=127.0.0.1;dbname=test','root','root');
 	
	$data=json_decode($data,true);
	$connection->name=$data['name'];
	$connection->img=$data['img'];
	$userlist=array();
	foreach ($http_worker->connections as $key =>$conn) {
		$userlist['name'][]=$conn->name;
	}
	$data['usernum']=count($http_worker->connections);
	$data['userlist']=$userlist;
	switch ($data['type']) {
		case 'login':
		$data['time']=date("Y-m-d H:i:s");
		SendAll(json_encode($data));
		break;
		case 'sendMsg':
		$data['time']=date("Y-m-d H:i:s");
		$pdo->exec("insert into lishi(`name`,headimg,connect,time,to_name) values('".$data['name']."','".$data['img']."','".$data['msg']."','".$data['time']."',0)");
		SendAll(json_encode($data));
		break;
		case 'sendMsgTo':
		$data['time']=date("Y-m-d H:i:s");
		$pdo->exec("insert into lishi(`name`,headimg,connect,time,to_name) values('".$data['name']."','".$data['img']."','".$data['msg']."','".$data['time']."','".$data['toname']."')");
		SendOne(json_encode($data),$data['toname']);
		break;	
		case 'sendImage':
		$data['time']=date("Y-m-d H:i:s");
		$pdo->exec("insert into lishi(`name`,headimg,connect,time,to_name) values('".$data['name']."','".$data['img']."','".$data['msg']."','".$data['time']."',0)");
		SendAll(json_encode($data));
		break;	
		case 'sendFiles':
		$data['time']=date("Y-m-d H:i:s");
		$pdo->exec("insert into lishi(`name`,headimg,connect,time,to_name) values('".$data['name']."','".$data['img']."','".$data['msg']."','".$data['time']."',0)");
		SendAll(json_encode($data));
		break;	
		case 'invisible'://隐身
		$connection->type=1;
		SendAll(json_encode($data));
		break;	
		case 'sendTofriend'://添加好友
		SendOne(json_encode($data),$data['toname'],$data['name']); 
		break;
		case 'sendAgree'://同意好友
		$pdo->exec("insert into `friend`(`user`,`friend`) values('".$data['toname']."','".$data['name']."')");
		$pdo->exec("insert into `friend`(`user`,`friend`) values('".$data['name']."','".$data['toname']."')"); 
		SendOne(json_encode($data),$data['toname'],$data['name']); 
		break;	
		case 'Startlive'://同意好友
		$connection->type=1;
		SendAll(json_encode($data));
		break;
		case 'SendLiwu'://同意好友
		$data['time']=date("Y-m-d H:i:s");
		$pdo->exec("insert into `liwu`(`toname`,`forname`,`num`,`type`,`time`) values('".$data['toname']."','".$data['name']."','".$data['num']."','".$data['id']."','".$data['time']."')"); 
		SendAll(json_encode($data));
		break;	
}

	

}
function onClose($connection)
{	
	global $http_worker;
	$userlist=array();
	foreach ($http_worker->connections as $conn) {
		$userlist['name'][]=$conn->name;
	}

	$data=array(
				'name'=>$connection->name,
				'time'=>date("Y-m-d H:i:s"),
				'type'=>'logout',

				);
	$data['usernum']=count($http_worker->connections);
	$data['userlist']=$userlist;
	SendAll(json_encode($data));
}
function SendAll($msg){
	global $http_worker;
	foreach ($http_worker->connections as $conn) {
		$conn->send($msg);
	}

}	
function SendOne($msg,$touser){
	global $http_worker;
	foreach ($http_worker->connections as $conn) {
		if($conn->name==$touser){
			$conn->send($msg);
		}
		
	}

}

// ¿¿worker
// Worker::runAll();
