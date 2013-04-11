<?php

class Notify {

    static function showFlash(){

        if(isset($_SESSION['flash'])){
            foreach($_SESSION['flash'] as $k => $v){
                if($v['format'] == 'single'){
                    print '<div class="alert alert-'.$v['type'].'">'.$v['message'].'</div>';
                }elseif($v['format'] == 'block'){
                    print '<div class="alert-message block-message '.$v['type'].'">';
                    print '<p><strong>Please correct the following errors:</strong></p>';
                    print $v['message'];
                    print '</div>';
                }
            }
            print '<div class="clear"></div>';
            //print '<div style="height: 10px;">&nbsp;</div>';
            unset($_SESSION['flash']);
        }

    }

    static function setFlash($message, $type='success', $format = 'single'){
        $mt = microtime();
        $_SESSION['flash'][$mt] = array(
                                        'message' => ($message instanceof \Exception ? $message->getMessage() : $message),
                                        'type' => $type,
                                        'format' => $format
                                      );

    }

    static function error($e){

        if($e instanceof \Origin\Core\Exception\MultiException){

            self::setFlash($e->getMessage(), 'error');
            self::setFlash($e->getErrors(), 'error', 'block');


        }elseif(is_array($e)){
            foreach($e as $m){
                self::setFlash($m, 'error');
            }
        }else{
            self::setFlash($e, 'error');
        }

        
    }

    static function alert($message){
        self::setFlash($message, 'warning');
    }

    static function success($message){
        self::setFlash($message);
    }

    static function setValidation($val){
        
        foreach($val->errors() as $error){
            self::error((string)$error);
        }

    }

}