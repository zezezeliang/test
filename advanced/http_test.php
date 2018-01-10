<?php
use Workerman\Worker;
require_once '../Workerman/Autoloader.php';

$http_worker = new Worker("websocket://0.0.0.0:1234");

// ¿¿4¿¿¿¿¿¿¿¿¿
$http_worker->count = 4;

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
		$userlist[$key]['name']=$conn->name;
		$userlist[$key]['img']=$conn->img;
	}
	$data['usernum']=count($http_worker->connections);
	$data['userlist']=$userlist;
	switch ($data['type']) {
		case 'login':
			$data['time']=date("Y-m-d H:i:s");
			// echo 1;
			SendAll(json_encode($data));
			// $connection->send(json_encode($data));
			break;
		case 'sendMsg':

			$data['time']=date("Y-m-d H:i:s");
			// var_dump($data);
			
			$pdo->exec("insert into lishi(`name`,headimg,connect,time,to_name) values('".$data['name']."','".$data['img']."','".$data['msg']."','".$data['time']."',0)");
			// echo $sql;
			SendAll(json_encode($data));
			// $connection->send(json_encode($data));
			break;

		
		
}

	

}
function onClose($connection)
{	
	global $http_worker;
	$userlist=array();
	foreach ($http_worker->connections as $conn) {
		$userlist[]=$conn->name;
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

// ¿¿worker
Worker::runAll();
