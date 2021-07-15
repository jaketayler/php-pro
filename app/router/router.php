<?php 

// Function to request file with array of routes

function routes(){
	return require 'routes.php';
}

//  Function to match routes existent with list of routes
function exactMatchUriInArrayRoutes($uri, $routes){
	if(array_key_exists($uri, $routes)){
		return [$uri => $routes[$uri]];
	}
	return [];
}

//  Function for regular expressions to combine array routes
function regularExpressionnMatchArrayRoutes($uri,$routes){
	return array_filter(
		$routes, function($value) use ($uri){
			$regex = str_replace('/', '\/', ltrim($value, '/'));
			return preg_match("/^$regex$/", ltrim($uri, '/'));
		}, ARRAY_FILTER_USE_KEY
	);			
}

// Function to captura uri paramaters 
function params($uri, $matchedUri){
	if(!empty($matchedUri)){	
		$matchedToGetParams = array_keys($matchedUri)[0];
		return array_diff(
			explode('/', ltrim($uri,'/')),
			explode('/', ltrim($matchedToGetParams,'/'))
		);
	}
	return [];
}

// Function to format parameters 
function formatParams(){
	$uri = explode('/', ltrim($uri,'/'));
	$paramsData = [];
	
	foreach ($params as $index => $param) {
		$paramsData[$uri[$index - 1]] = $param;				
	}
}

// Function to validate routes in application
function router(){
	
	$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	
	$routes = routes();

	$matchedUri = exactMatchUriInArrayRoutes($uri, $routes);

	if(empty($matchedUri)){
		$matchedUri = regularExpressionnMatchArrayRoutes($uri,$routes);

		if(!empty($matchedUri)){	
			$params = params($uri,$matchedUri);

			var_dump($paramsData);
			die();
		}
	}

	var_dump($matchedUri);
	die();
}