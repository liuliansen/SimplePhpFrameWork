<?php
namespace includes;

class Logger
{
    static public function log($file, $line, $message)
    {
        $info = date('Y-m-d H:i:s')."\t".$file."\t".$line."\t".$message;
        file_put_contents(App::getConf('rootPath').'/temp/web.log',$info,FILE_APPEND);
    }


}