<?php
	require_once 'vendor/autoload.php';
	require_once 'Configuration.php';



	$databaseConfiguration = new App\Core\DatabaseConfiguration(
		Configuration::DATABASE_HOST,
		Configuration::DATABASE_USER,
		Configuration::DATABASE_PASS,
		Configuration::DATABASE_NAME
	);
	$databaseConnection = new App\Core\DatabaseConnection($databaseConfiguration);


	$url = filter_input(INPUT_GET, 'URL');
	$httpMethod = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

	$router = new App\Core\Router();
	$routes = require_once 'Routes.php';
	foreach ($routes as $route) {
		$router->add($route);
	}

	$route = $router->find($httpMethod, $url);

	print_r($route);
	exit;

	# Rutiranje!
	# Smatraćemo da se uvek trazi MainController i njegov metod home.

	$controller = new \App\Controllers\MainController($databaseConnection);
	$controller->home();
	$data = $controller->getData();
	

	foreach ($data as $name => $value) {
		$$name = $value;
	}
	require_once 'views/Main/home.php';




