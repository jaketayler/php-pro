<?php
require 'bootstrap.php';

try {
    router();

    require VIEW_PATH.'/template.php';

} catch (Exception $e) {
    var_dump($e->getMessage());
}


