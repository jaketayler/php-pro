<?php

/**
 * @throws Exception
 */
function controller($matchedUri, $params){
  list($controller,$method) =explode ('@',array_values($matchedUri)[0]);
  $controllerWithPath = CONTROLLER_PATH.$controller;

  if (!class_exists($controllerWithPath)) {
    throw new Exception("Controller {$controller} não existe");
  } 
  
  $controllerInstance = new $controllerWithPath;

  if(!method_exists($controllerInstance,$method)){
    throw new Exception("O método {$method} não exite no controller  {$controller}.");
  }

  $controllerInstance->$method($params);

}