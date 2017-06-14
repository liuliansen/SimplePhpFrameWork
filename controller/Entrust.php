<?php
namespace controller;
use controller\Base;
use includes\App;
use kz_com\GetEntrustAndUsercoin as GetEntrustAndUsercoin;
use kz_com\Entrust as KzEntrust;
use kz_com\exception\RemoteReadException;

class Entrust extends Base
{

    public function getUserCoinAction()
    {
        try {
            $model = $this->getModel('KZCookie');
            $api = new GetEntrustAndUsercoin($model->getUserCookie($_SESSION['user_id']));
            $data = $api->get();
            App::sendBack(true,'',['usercoin' => $data['usercoin']]);
        } catch (RemoteReadException  $ex) {
            App::sendBack(false, $ex->getMessage());

        }
    }


    public function entrustAction()
    {
        try {
            $model = $this->getModel('User');
            $traderPassword = $model->getUserTraderPassword($_SESSION['user_id']);
            if (empty($traderPassword)) {
                App::sendBack(false, '酷赚交易密码未填写,请在资料中补充。');
            }
            $type = App::$request->get('type',1,'');
            if(empty($type))  App::sendBack(false, '委托类型获取失败');
            $price = App::$request->get('price',1,'');
            if(empty($price) || !preg_match('/^\d+(\.\d+)?$/',$price)) {
                App::sendBack(false, '委托价格不合法');
            }
            $qty = App::$request->get('quantity',1,'');
            if(empty($qty) || !preg_match('/^\d+(\.\d+)?$/',$qty)) {
                App::sendBack(false, '委托数量不合法');
            }
            $model = $this->getModel('KZCookie');
            $api = new KzEntrust($model->getByUserId($_SESSION['user_id']));
            if(!$api->entrust($price,$qty,$traderPassword,$type)){
                App::sendBack(false, $api->getLastErrorMsg());
            }
            App::sendBack();
        } catch (RemoteReadException  $ex) {
            App::sendBack(false, $ex->getMessage());

        }
    }


    public function getEntrustListAction()
    {
        try {
            $model = $this->getModel('KZCookie');
            $api = new GetEntrustAndUsercoin($model->getUserCookie($_SESSION['user_id']));
            $data = $api->get();
            App::sendBack(true,'',['entrust_list' => $data['entrust']]);
        } catch (RemoteReadException  $ex) {
            App::sendBack(false, $ex->getMessage());

        }
    }

}