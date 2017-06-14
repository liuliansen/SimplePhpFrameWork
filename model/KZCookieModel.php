<?php
namespace model;
use kz_com\GetCookie;
use model\Model;
use model\IModel;
use \Exception as Exception;

class KZCookieModel extends Model implements IModel
{
    /**
     * @param array $args
     */
    public function get($args = array())
    {

    }


    public function getByUserId($userId)
    {
        return $this->query('getAll','getRow', [':userId' => $userId]);
    }

    public function getUserCookie($userId)
    {
        return $this->query('getUserCookie','getOne', [':userId' => $userId]);
    }

    /**
     * @param array $args
     * @return array|int|mixed|string
     */
    public function add($args = array())
    {
        return $this->query('add','insert',$args);
    }

    /**
     * @param string $userId
     * @return array|int|mixed|string
     */
    public function delete($userId = ''){
        return $this->query('delete','delete',$userId? [':userId' =>$userId ] : []);
    }

    /**
     * @param $userId
     * @param array $cookieArray
     * @return array|int|mixed|string
     */
    public function update($userId, $cookieArray = array())
    {
        return $this->query('update','update',[
            ':userId' => $userId,
            ':cookie' => GetCookie::cookieArray2Str($cookieArray)]);
    }

    /**
     * @param $userId
     * @param array $cookieArray
     * @return array|int|mixed|string
     */
    public function save($userId, $cookieArray = array())
    {
        if($this->getUserCookie($userId)) {
            return $this->query('update','update',[
                ':userId' => $userId,
                ':cookie' => GetCookie::cookieArray2Str($cookieArray)]);
        }else{
            return $this->query('add','insert',[
                ':userId' => $userId,
                ':cookie' => GetCookie::cookieArray2Str($cookieArray)]);
        }
    }



}