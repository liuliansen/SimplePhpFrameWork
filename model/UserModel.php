<?php
namespace model;
use model\Model;
use model\IModel;
use \Exception as Exception;

class UserModel extends Model implements IModel
{
    /**
     * @param array $args
     */
    public function get($args = array())
    {

    }


    public function getAll($args = array())
    {
        return $this->query('getAll','getAll', $args);
    }


    /**
     * @param $user
     * @return array|int|mixed|string
     */
    public function getByUser($user)
    {
        return $this->query('getAll','getRow',[':user'=>$user]);
    }

    /**
     * @param $phone
     * @return array|int|mixed|string
     */
    public function getByPhone($phone)
    {
        return $this->query('getAll','getRow',[':phone'=>$phone]);
    }

    /**
     * @param array $args
     * @return array|int|mixed|string
     */
    public function add($args = array())
    {
        return $this->query('add','insert',[
            ':user' => $args['user'],
            ':password' => $args['password'],
            ':email' => $args['email'],
            ':phone' => $args['phone']
        ]);
    }


    public function getUserTraderPassword($userId)
    {
        return $this->query('getUserTraderPassword','getOne',[
            ':userId' =>  $userId ]);
    }

}