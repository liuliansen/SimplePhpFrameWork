<?php
namespace controller;
use includes\App;
use \Exception as Exception;
use includes\TemplateNotFoundException;
use model\IModel;
use model\Model;

class Base
{
    public function display($tplName,$param)
    {
        $className = get_class($this);
        $className = strtolower(substr($className,strrpos($className,'\\')+1));
        extract($param);
        $tpl = App::getConf('rootPath') .'/view/'.$className.'/'.$tplName.'.php';
        if(!is_file($tpl)) throw new TemplateNotFoundException('模板文件:'.$className.'/'.$tplName.'.php'.' 不存在.');
        include $tpl;
    }


    /**
     * @param $modelName
     * @return IModel
     */
    public function getModel($modelName)
    {
        $class = 'model\\'.$modelName.'Model';

        return new $class();
    }
}