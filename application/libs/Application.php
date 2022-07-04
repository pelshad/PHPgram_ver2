<?php
    namespace application\libs;

    require_once "application/utils/UrlUtils.php";
    require_once "application/utils/SessionUtils.php";
    require_once "application/utils/FileUtils.php";

    class Application {
        
        public $controller;
        public $action;
        private static $modelList = []; 
        //Application 객체랑 직접적인 관계는 X
        //다만 접근하기 위해선 Application 객체를 통해 접근가능

        public function __construct() {        
            $urlPaths = getUrlPaths();
            $controller = isset($urlPaths[0]) && $urlPaths[0] != '' ? $urlPaths[0] : 'board';
            $action = isset($urlPaths[1]) && $urlPaths[1] != '' ? $urlPaths[1] : 'index';

            if (!file_exists('application/controllers/'. $controller .'Controller.php')) {
                echo "해당 컨트롤러가 존재하지 않습니다.";
                exit();
            }

            $controllerName = 'application\controllers\\' .$controller . 'controller';

            $model = $this->getModel($controller);
            new $controllerName($action, $model);
        }

        public static function getModel($key)
        {
            if (!in_array($key, static::$modelList)) {
                $modelName = 'application\models\\' . $key . 'model';
                static::$modelList[$key] = new $modelName();
                //static:: <-스태틱 메모리 접근
                //다른 객체에선 Application 객체를 통해서 접근
                //싱글톤 참고
            }
            return static::$modelList[$key];
        }
    }