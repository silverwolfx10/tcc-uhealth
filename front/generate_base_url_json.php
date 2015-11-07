<?php
    define('DS', DIRECTORY_SEPARATOR);

	$verifyExists = function($extension){
		$directory = __DIR__.'/../infrastructure/config/'.$extension.'.config.php';
		
		return file_exists($directory) ? $directory : false;
	};
	
	$config = include $verifyExists('local')? : $verifyExists('global');

	$file = fopen("base_url.json","w");
	fwrite($file, json_encode($config['baseUrl']));
	fclose($file);
