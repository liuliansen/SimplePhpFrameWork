<?php
namespace includes;

use \PDO as PDO;

class DbHelper
{
    static private $instance = null;
    /**
     * @var null
     */
    private $conn = null;

    /**
     * DbHelper constructor.
     * @param $host
     * @param $port
     * @param $dbname
     * @param $user
     * @param $pwd
     * @param bool $setUTF8
     */
    private function __construct($host, $port,$dbname,$user,$pwd,$setUTF8 = true){
        $this->conn =  new PDO(
            'mysql:host='. $host.';port='.$port.';dbname='.$dbname,  $user,$pwd,
            [ PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC ]);
        if($setUTF8) {
            $this->conn->query('set names "utf8"');
        }

    }

    /**
     * @param $host
     * @param $port
     * @param $dbname
     * @param $user
     * @param $pwd
     * @param bool $setUTF8
     * @return DbHelper
     */
    static public function getInstance($host, $port,$dbname,$user,$pwd,$setUTF8 = true)
    {
        if(static::$instance == null){
            self::$instance = new self($host, $port,$dbname,$user,$pwd,$setUTF8);
        }
        return static::$instance;
    }

    /**
     * @return null|PDO
     */
    public function getConn()
    {
        return $this->conn;
    }
}
