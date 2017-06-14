<?php
namespace model;
use includes\DbHelper;
use includes\App;
use \Exception as Exception;
use includes\exception\SqlNotFoundException;
use includes\exception\SqlSyntaxException;

class Model
{
    protected $tablename = '';

    protected $sql = [];

    /**
     * @var \PDO
     */
    protected $conn = null;
    
    protected $paramsSort = [
        'orderby',
        'limit'
    ];
    
    /**
     * 获取当前模型的数据表名称
     */
    public function getTableName(){

    }


    /**
     * Model constructor.
     */
    public function __construct()
    {
        $mysql = App::getConf('mysql');
        $this->conn = DbHelper::getInstance(
            $mysql['host'],
            $mysql['port'],
            $mysql['dbname'],
            $mysql['user'],
            $mysql['password'])->getConn();
        if(empty($this->sql)) {
            preg_match('/^.*\\\(.*)Model$/', get_class($this), $class);
            $sqlDir = App::getConf('rootPath').'/sql'.'/'. strtolower($class[1]);
            if(is_dir($sqlDir)) {
                foreach (scandir($sqlDir) as $file) {
                    $file = $sqlDir.'/'.$file;
                    if (is_file($file)) {
                        $this->sql = array_merge(
                            $this->sql,  include $file );
                    }
                }
            }
        }
    }


    /**
     * @param $sqlName
     * @param $type
     * @param array $args
     * @return array|int|mixed|string
     * @throws Exception
     */
    public function query($sqlName, $type, $args=array())
    {
        if ($this->sql[$sqlName]) {
            $stmt = $this->conn->prepare($this->createSql($sqlName, $args));
            $stmt->execute($args);
            if(intval($stmt->errorCode())) {
                throw new Exception(implode(';',$stmt->errorInfo()));
            }
            switch (strtolower($type)) {
                case 'insert':
                    if ($stmt->rowCount()) {
                        return $this->conn->lastInsertId();
                    }else {
                        return false;
                    }
                case 'update':
                case 'delete':
                    return $stmt->rowCount();
                case 'getall':
                    return $stmt->fetchAll();
                case 'getrow':
                    return $stmt->fetch();
                case 'getone':
                    return $stmt->fetchColumn();
                    break;
                default:throw new Exception('Unsupported query type.');
            }
        } else {
           throw new Exception('Can not found Sql:'.$sqlName);
        }
    }


    public function createSql($sqlName , &$args)
    {
        if ($this->sql[$sqlName]) {
            $set = $this->sql[$sqlName];
            if(is_string($set)) {
                if(isset($args['orderby'])) {
                    $set .= ' ORDER BY '.$args['orderby'];
                    uset($args['orderby']);
                }
                return $set;
            }else{
                if(isset($set['sql'])) {
                    $main = $set['sql'];
                    if($args) {
                        $defaultWhere = $set['defaultWhere'] || false;
                        $where =  $set['where'] ?: [];
                        $orderby = '';
                        foreach ($args as $k => $w) {
                            if(isset($where[$k])) {
                                $whereSet = $where[$k];
                                if(!isset($whereSet['sql'])) {
                                    throw new SqlSyntaxException('SQL where sub sql not set.');
                                }
                                if(!isset($whereSet['link'])) {
                                    throw new SqlSyntaxException('SQL where link type not set.');
                                }
                                switch (strtolower($whereSet['link'])) {
                                    case 'and':
                                        if ($defaultWhere) {
                                            $main .= ' AND '.$whereSet['sql'];
                                        } else {
                                            $main .= ' WHERE '.$whereSet['sql'];
                                            $defaultWhere = true;
                                        }
                                        break;
                                    case 'or':
                                        if ($defaultWhere) {
                                            $main .= ' OR '.$whereSet['sql'];
                                        } else {
                                            $main .= ' WHERE '.$whereSet['sql'];
                                            $defaultWhere = true;
                                        }
                                        break;
                                    default: throw new SqlSyntaxException('Unsupported SQL where link type.');
                                }
                            }else{
                                if($k == 'orderby') {
                                    $orderby = ' ORDER BY '.$args['orderby'];
                                    uset($args['orderby']);
                                }elseif(!in_array($k, $set['pdoParam'])){
                                    unset($args[$k]);
                                }
                            }
                        }
                        return $main.$orderby;

                    }else{
                        return $main;
                    }
                }else{
                    throw new SqlNotFoundException('sql:'.$sqlName.' not found.');
                }
            }
        }else {
            throw new SqlNotFoundException('sql:'.$sqlName.' not configure.');
        }
    }



}