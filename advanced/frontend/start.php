<?php
use Workerman\Worker;

	foreach (glob('start_*.php') as $file) {
		// var_dump($file);
		include_once $file;
	}
Worker::runAll();