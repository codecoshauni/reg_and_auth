<?php

function autoloader($class) {
    $class = preg_replace('/^App\\\\/', '', $class);
    $classPath =  __DIR__ . "/" . str_replace('\\', '/', $class) . '.php';

    if (file_exists($classPath)) {
        require_once($classPath);
    }
}