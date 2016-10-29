<?php

class Controller{
    
        
    public $controller;
    public $action;
    public $params = null;
    public $variables = array();
    public $layout = 'Default';
    
    
    

    public function __construct($request) {
        
        $this->controller = $request['controller'];
        $this->action = $request['action'];
        $this->params = $request['params'];
        
     
        if ($this->action == null){
            $this->action = 'index';
        }else{
            
            
            $sMethod = $this->action;
               if (method_exists($this, $sMethod)){
                   
                    $reflection = new ReflectionMethod($this, $sMethod);
                    if (!$reflection->isPublic()) {
                        
                        // Not Public Function.
                        $this->action = 'index';
                        
                    }else{
                        
                        // Function is public and exists.
                        $this->action = $sMethod;
                    }
                } else {
                    
                    // The function is not existed.
                    $this->action = 'index';
                }
        }
        
        
        $this->fetchView();

       
    }
    
    
    public function set($varName = null, $varValue = null){

            
            if ( ($varName == '' || $varName == null) && DEBUG === true ){
                Debugger::warn('Variable name is not set. var Value ('.$varValue.')');
            }
            
            
            if ( ($varValue == '' || $varValue == null) && DEBUG === true ){
                Debugger::warn('Variable value is not set. var Name ('.$varName.')');
            }
           
        $this->variables[$varName] = $varValue; 
    }
    
    public function fetchView(){
        
        $view = new View();
        
        $view->controller = $this->controller;
        
        $view->action = $this->action;
        
        $this->{$this->action}();
        
        $view->layout = uf($this->layout);
        
        $view->variabels = $this->variables;
        $view->renderTemplate();
        
        
        
    }
    

    
    
}