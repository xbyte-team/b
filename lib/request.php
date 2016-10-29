<?php

class Request{
    
    
    public  $controller = null,
            $action = null, 
            $params = null ;
    
    
    
    private function _urlFilter($data){
        return urlencode($data);
    }
    
    
    private function _urlPares($data_){
        
        $data = explode('/', $data_);
        
        $uriArray = array();
        
        foreach ($data as $value) {
                if ($value != ''){
                    $value = preg_replace('/\..*/', '', $value);
                    $uriArray[] = $this->_urlFilter($value);
                }
                
                
                
            }
            
            if (is_array($uriArray) && sizeof($uriArray) == 1){$uriArray = $uriArray[0];}
            
            

        if (sizeof($uriArray) == 0){
            
            $ctrl = null;
            $actn = null;
            $prms = null;
            
        }else if (sizeof($uriArray)==1){
            
            $ctrl = $uriArray;
            $actn = null;
            $prms = null;
            
        }else{
    
            $ctrl = array_shift($uriArray);
            $actn = array_shift($uriArray);
            $prms = $uriArray;

        }
        
        
       
        
        $thisArray['controller'] = $ctrl;
        $thisArray['action'] = $actn;
        $thisArray['params'] = $prms;
        return $thisArray; 
    }
    
 
    

    
    
    public function __construct() {

        $uri = $this->_urlPares($_SERVER['REQUEST_URI']);
        
        $this->controller = $uri['controller'];
        $this->action = $uri['action'];
        $this->params = $uri['params'];
        
        $this->rectifier();
        
    }
    
    public function getState(){
        return $this->controller;
    }
       
    
    
    public function rectifier(){
        
        if ($this->controller === null || $this->controller[0] == '_' || is_numeric($this->controller[0])){
            $controllerName = $this->controller = 'Home';
            $this->action = 'index';
        }

        if ($this->action === null || $this->action == ''){
            $this->action = 'index';
        }
        
        
    }
    
    public function returnments(){

        return [
            'controller' => $this->controller,
            'action' => $this->action,
            'params' => $this->params,
        ];
    }
    
    
    
}