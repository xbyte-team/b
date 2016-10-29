<?php

class Debugger{
    
   
    public static $log   = [];
    public static $info  = [];
    public static $warn  = [];
    public static $error = [];

    public function __construct() {
    
        
        
    } 
 
    
    public static function info($input){
        
        self::$info[] = $input;
        return true;
    }
    public static function log($input){
                
        self::$log[] = $input;
        return true;
    }
    public static function warn($input){
                
        self::$warn[] = $input;
        return true;
    }
    public static function error($input){
                
        self::$error[] = $input;
        return true;
    }
    
    public static function data(){
        
        $dataArray = [];
        
        
        $dataArray['log']   = self::$log;
        $dataArray['info']  = self::$info;
        $dataArray['warn']  = self::$warn;
        $dataArray['error'] = self::$error;
    
        return $dataArray;
        
    }
}