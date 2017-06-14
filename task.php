<?php
spl_autoload_register(function($className){
    $classFile = __DIR__ .'/'. str_replace('\\','/',$className). '.php';
    if(is_file($classFile)) require $classFile;
});

require 'vendor/autoload.php';

use includes\App;
use includes\Logger;
use includes\Mailer;
App::$model = 'cli';

try{
    if(!isset($argv[1])) {
        throw new Exception("任务名称未指定\n");
    }
    $ref = new ReflectionClass(getTaskClassName($argv[1]));

    $pid = pcntl_fork();
    if($pid === -1) {
        throw new Exception('子进程创建失败');
    }elseif($pid>0){
        exit(0); //退出主进程
    }
    posix_setsid();
    chdir('/');

    $pid = pcntl_fork();
    if($pid === -1) {
        throw new Exception('子进程创建失败');
    }elseif($pid>0){
        exit(0); //再次退出主进程
    }
    fclose(STDIN);
    fclose(STDOUT);
    fclose(STDERR);

    declare(ticks=1);
    pcntl_signal(SIGTERM, "sig_handler");
    pcntl_signal(SIGILL,  "sig_handler");
    pcntl_signal(SIGABRT, "sig_handler");

    App::newInstance(array_merge(
        require __DIR__ .'/config/web.php',
        require __DIR__ .'/config/web.local.php'
    ))->runTask($ref->newInstance(getArgs($argv)));
}catch (Exception $ex){
    file_put_contents(App::$RootPath .'/temp/logs/task.log', date('Y-m-d H:i:s') ."\t" .$ex->getMessage(). PHP_EOL , FILE_APPEND);
    exit(1);
}

/**
 * @param $taskName
 * @return string
 */
function getTaskClassName($taskName)
{
    return 'task\\'.ucfirst($taskName);
}

/**
 * @param $cliArgv
 * @return array
 */
function getArgs($cliArgv)
{
    $args = [];
    for ($i = 2; $i < count($cliArgv); $i++) {
        $args[] = $cliArgv[$i];
    }
    return $args;
}

function sig_handler($signo)
{
    try{
        Mailer::sendMail('332302326@qq.com','admin','酷赚数据采集失败','酷赚数据采集程序已退出');
    }catch (Exception $exx) {
        Logger::log($exx->getFile(), $exx->getLine(), $exx->getMessage());
    }
    exit(0);
}