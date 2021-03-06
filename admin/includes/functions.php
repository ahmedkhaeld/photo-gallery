<?php
function redirect($location)
{
    header("Location: {$location}");
}

function classAutoLoader($class)
{
    $class = strtolower($class);
    $path = "includes/{$class}.php";
    if (is_file($path) && !class_exists($class)) {
        include $path;
    }
}
spl_autoload_register('classAutoLoader');