deploy:
	cd front && php generate_base_url_json.php && gulp
doctrine-update-sql:
	php userinterface/shell/doctrine_cli.php orm:schema-tool:update --dump-sql
doctrine-update-force:
	php userinterface/shell/doctrine_cli.php orm:schema-tool:update --force
doctrine-fixtures-import:
	 php userinterface/shell/app.php DataFixtures import
phpunit:
	chmod +x phpunit.phar && cp phpunit.phar /usr/local/bin/phpunit
zsh:
	wget http://github.com/robbyrussell/oh-my-zsh/raw/master/tools/install.sh -O - | zsh
hosts:
	echo '127.0.0.1 www.uhealth.com.br api.uhealth.com.br' >> /etc/hosts
