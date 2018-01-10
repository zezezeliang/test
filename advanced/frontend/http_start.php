<?php
use Workerman\Worker;
require_once '../Workerman/Autoloader.php';
$http_worker = new Worker("websocket://0.0.0.0:2221");
$http_worker->count = 4;
$http_worker->onConnect = "onConnect";
$http_worker->onMessage = "onMessage";
function onConnect($connection){

	echo "id:".$connection->id."``````";
	echo "ip:".$connection->getRemoteIp()."\n";

}
function onMessage($connection,$data){
	global $http_worker;
	$data=json_decode($data,true);
	// $connection->name=$data['name'];
	var_dump($data);
		$pdo=new PDO('mysql:host=127.0.0.1;dbname=test','root','root');
		$rs = $pdo->query("SELECT * FROM `us` where `parentid`='".$data['name']."'");
    	$result_arr = $rs->fetchAll();
    	$mm=array();
    	foreach ($result_arr as $key => $value) {
    		$mm[$key]=$value['username'];
    		$mm[2]=$data['name'];
    	}
   		var_dump($mm);
   		
		foreach ($http_worker->connections as $conn) {

			if(in_array($data['name'],$mm)){
   				 $conn->send(json_encode($data));
   			}
			
			
		
		}

	
	
}
Worker::runAll();

?>