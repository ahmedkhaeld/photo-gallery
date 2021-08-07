<?php

function classAutoLoader($class) {
    $class=strtolower($class);
    $path="INCLUDE_PATH. {$class}.php";
    if(is_file($path) && !class_exists($class)){
        include $path;
    }
}
spl_autoload_register('classAutoLoader');
?>