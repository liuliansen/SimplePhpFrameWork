<?php
header("Content-type: text/html; charset=utf-8");
spl_autoload_register(function($className){
    $classFile = __DIR__ .'/'. str_replace('\\','/',$className). '.php';
    if(is_file($classFile)) require $classFile;
});
use includes\App;
App::newInstance(array_merge(
    require __DIR__ .'/config/web.php',
    require __DIR__ .'/config/web.local.php'
))->run();


