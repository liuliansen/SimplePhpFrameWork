<?php
namespace task;
use includes\App;
use task\ITask;
use task\Task;
use model\KzDailyModel;
use \Exception as Exception;

class DailyCount extends Task implements ITask
{
    public function run()
    {
        $model = new KzDailyModel();
        $model->add([
            ':date' => date('m-d'),
            ':addtimeGte'=> date('Y-m-d').' 00:00:00',
            ':addtimeLte'=> date('Y-m-d').' 23:59:59',
        ]);
    }



}