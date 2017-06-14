<?php

namespace controller;
use controller\Base;
use includes\App;
use \Exception as Exception;
use includes\Logger;
use kz_com\exception\RemoteReadException;
use kz_com\GetBaseData;
use kz_com\GetTopInfo;
use kz_com\GetTradeLog;

class KZCookie extends Base
{
    public function getBuyAndSaleAction()
    {
        try {
            $model = $this->getModel('KZCookie');
            switch (App::$request->get('type', 1, '')) {
                case 'buy':
                    $api = new GetBaseData(3, $model->getUserCookie($_SESSION['user_id']));
                    $data = $api->get();
                    $rows = [];
                    for ($i = 0; $i < count($data['depth']['buy']); $i++) {
                        $row = $data['depth']['buy'][$i];
                        $rows[] = [
                            'type' => 'buy',
                            'typeText' => '买' . ($i + 1),
                            'price' => number_format($row[0], 4),
                            'quantity' => number_format($row[1], 6),
                            'amount' => number_format(bcmul($row[0], $row[1], 6), 6)
                        ];
                    }
                    break;
                case 'sell':
                    $api = new GetBaseData(4, $model->getUserCookie($_SESSION['user_id']));
                    $data = $api->get();
                    $rows = [];
                    $total = count($data['depth']['sell']);
                    for ($i = 0; $i < count($data['depth']['sell']); $i++) {
                        $row = $data['depth']['sell'][$i];
                        $rows[] = [
                            'type' => 'sell',
                            'typeText' => '卖' . ($total--),
                            'price' => number_format($row[0], 4),
                            'quantity' => number_format($row[1], 6),
                            'amount' => number_format(bcmul($row[0], $row[1], 6), 6)
                        ];
                    }
                    break;
                default:
                    $api = new GetBaseData(1, $model->getUserCookie($_SESSION['user_id']));
                    $data = $api->get();
                    $rows = [];
                    $total = count($data['depth']['sell']);
                    for ($i = 0; $i < count($data['depth']['sell']); $i++) {
                        $row = $data['depth']['sell'][$i];
                        $rows[] = [
                            'type' => 'sell',
                            'typeText' => '卖' . ($total--),
                            'price' => number_format($row[0], 4),
                            'quantity' => number_format($row[1], 6),
                            'amount' => number_format(bcmul($row[0], $row[1], 6), 6)
                        ];
                    }
                    for ($i = 0; $i < count($data['depth']['buy']); $i++) {
                        $row = $data['depth']['buy'][$i];
                        $rows[] = [
                            'type' => 'buy',
                            'typeText' => '买' . ($i + 1),
                            'price' => number_format($row[0], 4),
                            'quantity' => number_format($row[1], 6),
                            'amount' => number_format(bcmul($row[0], $row[1], 6), 6)
                        ];
                    }
            }
            App::sendBack(true, '', ['data' => $rows]);
        }catch (RemoteReadException  $ex) {
            App::sendBack(false, $ex->getMessage());
        }

    }


    public function getTradeLogAction()
    {
        try {
            $model = $this->getModel('KZCookie');
            $api = new GetTradeLog($model->getUserCookie($_SESSION['user_id']));
            $data= $api->get();
            $rows = [];
            for ($i = 0; $i < count($data['tradelog']); $i++) {
                $row = $data['tradelog'][$i];
                $rows[] = [
                    'type' => $row['type'],
                    'typeText' => $row['type'] == '1' ? '买':'卖',
                    'addtime' => $row['addtime'],
                    'price' => number_format($row['price'], 4),
                    'quantity' => number_format($row['num'], 6),
                    'amount' => number_format($row['mum'],6)
                ];
            }
            App::sendBack(true, '', ['data' => $rows]);
        }catch (RemoteReadException  $ex) {
            App::sendBack(false, $ex->getMessage());
        }
    }

    public function getTopAction()
    {
        try {
            $model = $this->getModel('KZCookie');
            $api = new GetTopInfo($model->getUserCookie($_SESSION['user_id']));
            $data= $api->get();
            $data['info']['volume'] = bcdiv($data['info']['volume'],10000,2).'万';
            $data['info']['change'] .='%';
            $color = $data['info']['round'] == 2?'red' : 'green';
            $data['info']['new_price'] = '<span style="color:'.$color.';font-size:26px;">'.$data['info']['new_price'] .'</span>';
            $data['info']['change']    = '<span style="color:'.
                (floatval($data['info']['change']) > 0 ? 'red':'green').';font-size:18px;">'. $data['info']['change'] .'</span>';
            App::sendBack(true, '', ['data' => $data['info']]);
        }catch (RemoteReadException  $ex) {
            App::sendBack(false, $ex->getMessage());
        }
    }
}