<?php
namespace model;
use kz_com\GetCookie;
use model\Model;
use model\IModel;
use \Exception as Exception;

class KzTraderLogModel extends Model implements IModel
{
    /**
     * @param array $args
     */
    public function get($args = array())
    {
        return $this->query('getAll','getAll',$args);
    }

    /**
     * @param $md5
     * @return array|int|mixed|string
     */
    public function getByMd5($md5)
    {
        return $this->query('getAll','getRow',[':md5' => $md5]);
    }

    /**
     * @param array $args
     * @return array|int|mixed|string
     */
    public function add($args = array())
    {
        return $this->query('add','insert',$args);
    }



}