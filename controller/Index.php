<?php
namespace controller;
use controller\Base;
use includes\App;

class Index  extends  Base
{
    public function indexAction()
    {
        $this->display('index');
    }


    public function getDailyAvgPriceAction()
    {
        App::sendBack(true,'',[
            'data' => [
                ['date' => '05-22','value'=>'23'],
                ['date' => '05-23','value'=>'25'],
                ['date' => '05-24','value'=>'24'],
                ['date' => '05-25','value'=>'26'],
                ['date' => '05-26','value'=>'26'],
                ['date' => '05-27','value'=>'27'],
            ],
        ]);
    }
}