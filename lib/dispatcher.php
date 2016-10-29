<?php

class Dispatcher{
    
    public $request;
    
    public $state = null;
    
    public function __construct($request) {
        
        $this->request = $request;
        $this->controllerCall();
   
    }

    public function controllerCall(){

        if (file_exists( WWW_ROOT . DS . 'controllers' . DS . uf($this->request->controller .'.php'))){
            require WWW_ROOT. DS . 'controllers' . DS . uf($this->request->controller) . '.php';
            $controller = new $this->request->controller($this->request->returnments());
            $this->state = 200;
        }else{
            $this->request->controller = 'Error404';
            require WWW_ROOT. DS . 'controllers' . DS .'error404.php';
            $controller = new Error404($this->request->returnments());
            
            $this->state = 404;
            
        }
    }
    
}
