<?php
use Workerman\Worker;
//主播 - 推流
$live_worker=new Worker("websocket://0.0.0.0:10086");
//定义进程名称
$live_worker->name="live";
//定义进程启动时的回调函数
$live_worker->onWorkerStart = function($live_worker){

	//观众 - 拉流
	$people_worker = new Worker("websocket://0.0.0.0:10010");
	//观众-消息发送过来的回调函数
	$people_worker->onMessage = function($connection,$data){

	};
	//把当前观众的连接放到当前主播里面
	$live_worker->p_workdr=$people_worker;
	$people_worker->listen();
};
$live_worker->onMessage = function($connection,$data)use($live_worker){
	foreach ($live_worker->p_workdr->connections as $p_workdr) {
		$p_workdr->send($data);
	}
	// $connection->send($data);
};


?>