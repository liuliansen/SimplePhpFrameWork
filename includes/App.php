<?php
namespace includes;

use \ReflectionClass as ReflectionClass;
use \Exception as Exception;
use includes\ActionNotFoundException;
use includes\Request;
use task\ITask;

class App
{

    static public  $model = 'web';
    static public  $RootPath = '';
    static private $instance = null;

    /**
     * @var Config
     */
    static private $config = null;

    /**
     * @var Request
     */
    static public $request = null;

    /**
     * App constructor.
     * @param $config
     */
    private function __construct($config)
    {
        static::$config = Config::newInstance($config);
        static::$request = Request::newInstance($_REQUEST);
    }


    /**
     * @param $config
     * @return App
     */
    static public function newInstance($config)
    {
        if(static::$instance == null) {
            static::$instance = new self($config);
        }
        return static::$instance;
    }

    /**
     * @param $confName
     * @return mixed
     */
    static public function getConf($confName)
    {
        return static::$config->$confName;
    }

    /**
     *
     */
    public function run()
    {
        session_save_path(App::getConf('sessionPath'));
        session_write_close();
        session_start();
        $this->toDo($this->getRoute($_REQUEST));
    }


    /**
     * @param $request
     * @return array
     */
    private function getRoute($request)
    {
        $routeParam = App::getConf('routeParam');
        if(isset($request[$routeParam]) && trim($request[$routeParam]) != '') {
            $_r = explode('/', $request[$routeParam]);
            $route = [
                'ctrl'   => $_r[0],
                'action' => isset($_r[1]) ? $_r[1]:'index'
            ];
        }else {
            $route = ['ctrl' => 'index', 'action' => 'index'];
        }
        if(empty($_SESSION['user_id'])){
            $allowGuest = App::getConf('allowGuest');
            $guestCtrls = array_keys($allowGuest);
            if(!in_array($route['ctrl'],$guestCtrls) || !in_array($route['action'],$allowGuest[$route['ctrl']])) {
                header('Location:' . App::getConf('httpRoot') . '/index.php?' . App::getConf('routeParam') . '=login');
                exit(0);
            }
        }
        return $route;
    }

    /**
     * @param $route
     * @throws Exception
     */
    private function toDo($route)
    {
        try{
            $ref  = new ReflectionClass('controller\\'. ucfirst($route['ctrl']));
            $ctrl = $ref->newInstance();
            $action = $route['action'].'Action';
            if(method_exists($ctrl,$action)){
                $ctrl->$action();
            }else{
                throw new ActionNotFoundException('action不存在');
            }
        }catch (\ReflectionException $ex) {
            App::sendBack(false,$ex->getMessage());
        }catch (ActionNotFoundException $ex){
            App::sendBack(false,$ex->getMessage());
        }catch (TemplateNotFoundException $ex) {
            echo $ex->getMessage();
            exit(0);
        }
    }

    /**
     * @param bool $success
     * @param string $msg
     * @param array $data
     */
    static public function sendBack($success = true, $msg='', $data=array())
    {
        $result = [
            'success' => $success,
            'msg' => $msg
        ];
        if($data) $result = array_merge($result,$data);
        echo json_encode($result);
        exit(0);
    }


    /**
     * 执行任务
     * @param ITask $task
     */
    public function runTask(ITask $task)
    {
        $task->run();
    }

}