<?php
    spl_autoload_register(function ($path) {      
        $path = str_replace('\\','/',$path);
        $paths = explode('/', $path);


        /* 소스 중간에 보면 model과 controller 만 클래스 $className 변수에 저장하는 것을 볼 수 
           있습니다.그것은 Model과 Controller 는 모두 클래스로 만들어져 있지만View는 화면에 데이터를 
           출력하기 위해 class 가 아니라 html 코드를 품은 일반적인 php 파일 이기 때문입니다. */
        
        if (preg_match('/model/', strtolower($paths[1]))) {
            $className = 'models';
        } else if (preg_match('/controller/',strtolower($paths[1]))) {
            $className = 'controllers';
        } else {
            $className = 'libs';
        }

        $loadpath = $paths[0].'/'.$className.'/'.$paths[2].'.php';
        
       // echo 'autoload $path : ' . $loadpath . '<br>';
        
        if (!file_exists($loadpath)) {
            echo " --- autoload : file not found. ($loadpath) ";
            exit();
        }
        require_once $loadpath;
    });