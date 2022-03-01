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
			$uri,
			explode('/', ltrim($matchedToGetParams,'/'))
		);
	}
	return [];
}

// Function to format parameters 
function formatParams($uri, $params){
	$paramsData = [];
	
	foreach ($params as $index => $param) {
		$paramsData[$uri[$index - 1]] = $param;				
	}

	return $paramsData;
}

// Function to validate routes in application
/**
 * @throws Exception
 */
function router(){
	
	$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	
	$routes = routes();

	$matchedUri = exactMatchUriInArrayRoutes($uri, $routes);

    $params = [];
	if(empty($matchedUri)){
		$matchedUri = regularExpressionnMatchArrayRoutes($uri,$routes);
			$uri = explode('/', ltrim($uri,'/'));
			$params = params($uri,$matchedUri);
			$params = formatParams($uri,$params);
	}

	if(!empty($matchedUri)){
		controller($matchedUri, $params);
		return;

	}

	throw new Exception('Algo deu errado!!');
}