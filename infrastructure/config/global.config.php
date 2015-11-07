<?php
	return [
		'namespace' => ['Infrastructure' => __DIR__ . DS . '..'],
		'ormMapper' => [
			__DIR__ . DS . '..' . DS . '..' . DS .'domain' . DS . 'src' . DS . 'User' . DS . 'src' . DS . 'User' . DS . 'Entity',
            __DIR__ . DS . '..' . DS . '..' . DS .'domain' . DS . 'src' . DS . 'Review' . DS . 'src' . DS . 'Review' . DS . 'Entity',
            __DIR__ . DS . '..' . DS . '..' . DS .'domain' . DS . 'src' . DS . 'QuestionAndAnswer' . DS . 'src' . DS . 'QuestionAndAnswer' . DS . 'Entity',
            __DIR__ . DS . '..' . DS . '..' . DS .'domain' . DS . 'src' . DS . 'Ad' . DS . 'src' . DS . 'Ad' . DS . 'Entity',
            __DIR__ . DS . '..' . DS . '..' . DS .'domain' . DS . 'src' . DS . 'Address' . DS . 'src' . DS . 'Address' . DS . 'Entity',
		],
        'fixtures' => [
//            __DIR__ . DS . '..' . DS . '..' . DS .'domain' . DS . 'src' . DS . 'User' . DS . 'src' . DS . 'User' . DS . 'Fixture',
//            __DIR__ . DS . '..' . DS . '..' . DS .'domain' . DS . 'src' . DS . 'Review' . DS . 'src' . DS . 'Review' . DS . 'Fixture',
//            __DIR__ . DS . '..' . DS . '..' . DS .'domain' . DS . 'src' . DS . 'QuestionAndAnswer' . DS . 'src' . DS . 'QuestionAndAnswer' . DS . 'Fixture',
            __DIR__ . DS . '..' . DS . '..' . DS .'domain' . DS . 'src' . DS . 'Ad' . DS . 'src' . DS . 'Ad' . DS . 'Fixture',
//            __DIR__ . DS . '..' . DS . '..' . DS .'domain' . DS . 'src' . DS . 'Address' . DS . 'src' . DS . 'Address' . DS . 'Fixture',
        ],
		'databases' => [
			[
				'driver'  =>  'pdo_mysql',
                'user'	=>	'root',
	            'password'	=>	'',
	            'dbname'	=>	'',
	            'host'	=>	'mysql',
                'port'	=>	'3316',
                'driverOptions' => array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
                )

			]
		],
        'baseUrl' => [
            'www' => 'http://www.uhealth.com.br',
            'api' => 'http://api.uhealth.com.br'
        ],
        'credentials' => [
            'BasicAuthorization' => ''
        ]
	];