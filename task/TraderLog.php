<?php
namespace task;
use includes\App;
use includes\Logger;
use includes\Mailer;
use task\ITask;
use task\Task;
use model\KZCookieModel;
use model\KzTraderLogModel;
use kz_com\GetTradeLog;
use \Exception as Exception;

class TraderLog extends Task implements ITask
{

    private $errTimes    = 0;
    private $maxErrTimes = 0;

    public function run()
    {
        $model = new KZCookieModel();
        $cookie = $model->getUserCookie(App::getConf('cli')['user_id']);
        $api = new GetTradeLog($cookie);
        $stopTime = strtotime(date('Y-m-d') .' 21:31:00');
        while (true){
            if(time() >= $stopTime) break;
            try{
                $data = $api->get();
                if(isset($data['tradelog'])) {
                    $this->storageData($data['tradelog']);
                }else{
                    if(($this->errTimes++) == $this->maxErrTimes) {
                        throw new Exception('酷赚网数据请求失败次数,达到'. $this->maxErrTimes);
                    }
                }
            }catch (Exception $ex) {
                try{
                    Mailer::sendMail('332302326@qq.com','LianSen','酷赚数据采集失败', $ex->getMessage());
                }catch (Exception $exx) {
                    Logger::log($exx->getFile(), $exx->getLine(), $exx->getMessage());
                }
                exit(0);
            }
            sleep(3);
        }
    }

    /**
     * @param $data]
     */
    private function storageData($data)
    {
        $model = new KzTraderLogModel();
        $date = date('Y-');
        foreach ($data as $row) {
            $md5 = md5(implode(';',$row));
            if($model->getByMd5($md5)){ continue; }
            $model->add([
                ':addtime' => $date.$row['addtime'],
                ':type'    => $row['type'],
                ':price'   => $row['price'],
                ':num'     => $row['num'],
                ':mum'     => $row['mum'],
                ':md5'     => $md5
            ]);
        }
    }

}