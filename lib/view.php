<?php

class View{
    
    
    public $controller = null;
    public $action = null;
    public $layout = null;
    public $variabels = array();    
    
    
    
    private $__layoutFile;
    private $__templateFile;

    public $content = null; 
    public $blocks = array(); 
              
    public function __construct(){
        
    }
    public function __destruct() {
        
    }
    
    
    
    private function render($template){
         
        extract($this->variabels);
        if (!isset($title)){$title = WEBSITE_TITLE;}
        
        if(!require( uf($template) )){
            die('Can not load the file.');
        }
        
       
    }
    
    
    public function renderTemplate(){
        
        if ($this->controller !== null && $this->action !== null){

            $this->renderTemplate_();

        }else{

            die('Fetch View Error.');
        }
            
    }
    
    function renderTemplate_(){
        
        $this->__layoutFile = WWW_ROOT.  'templates' . DS . 'layouts' . DS . $this->layout . '.php';
        $this->__templateFile = WWW_ROOT. 'templates' . DS .uf($this->controller) . DS . $this->action . '.php';
        
        ob_start();

        $this->render($this->__templateFile);
        
        $this->content = ob_get_clean();
        
        
        echo $this->render($this->__layoutFile);
        
    }
    
    
    
    
    public function renderLayout(){
        $this->render($this->__layoutFile);
    }
    

    
    
    
    
    public function write($blockName, $blockValue){
 
         
            if ( ($blockName == '' || $blockName == null) && DEBUG === true ){
                Debugger::warn('Write function for the block-value('.$blockValue.') is not set.');
            }
            
            if ( ($blockValue == '' || $blockValue == null) && DEBUG === true ){
                Debugger::warn('Write function for the block-name ('.$blockName.') is not set.');
            }
            
            $this->blocks[$blockName][] = $blockValue ;
            
            return true;
            
    }
    
    public function element($input, $data = array()){
        
        
        
        $input = str_replace('/', DS , $input);
        
        $elementDir = WWW_ROOT . 'templates' .DS . 'elements' . DS;
        $element = $elementDir .  uf($input) . '.php';

        if (!empty($data)){
            extract($data);
            
        }else{
            extract($this->variabels);
        }
        if (!isset($title)){$title = WEBSITE_TITLE;}
        require $element;
        
    }
    
    
    public function fetch($input){
        
         if ($input == 'content'){
             
             echo $this->content;
             
         }else if($input == 'css' && !empty ($this->blocks[$input])){
             
             foreach ($this->blocks[$input] as $cssBlocks){
                 echo   '<link href="',
                            $cssBlocks,
                        '" rel="stylesheet">';
             }
             unset($this->blocks[$input]);
             echo PHP_EOL;
             
         }else if($input == 'js' && !empty ($this->blocks[$input])){
         
            foreach ($this->blocks[$input] as $jsBlocks){
                echo   '<script src="',
                        $jsBlocks,
                        '"></script> ';
             }
             unset($this->blocks[$input]);
             echo PHP_EOL;
             
         }else if ($input == 'meta' && !empty ($this->blocks[$input])){
         
            echo $this->fetchMeta($this->blocks[$input]);
            unset($this->blocks[$input]);
            echo PHP_EOL;
             
         }else{
             
            if (isset($this->blocks[$input])){
                
                foreach ($this->blocks[$input] as $blocks){
                    echo $blocks;
                }

                echo PHP_EOL;
                
            }
            
            
         }

     } 
    
    private function fetchMeta($data){
        
        $returnment = '';
        
        foreach ($data as $metaBlock){
            $returnment .= '<meta ';  

            foreach ($metaBlock as $metaKey => $metaValue){
                $returnment .= $metaKey. '="'.$metaValue.'" ';
            }
                
            $returnment .= '/> ';    

        }
        
        return $returnment;
    }


    
    
 
    
}