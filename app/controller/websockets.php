<?php
  include(dirname(__FILE__).'/../config/config.php');
  include($c->getDir('config').'model.php');
  
  function executeVoidTest($data){
    $ret = array(
      'status'  => 'ok',
      'message' => '-'.$data['message'].'-'
    );
    return $ret;
  }
  
  function executeVoidLogin($data){
    $ret = array(
      'action' => 'voidLogin',
      'status' => 'ok',
      'auth'   => '',
      'uuid'   => $data['uuid']
    );
    
    $email = urldecode($data['email']);
    $pass  = sha1('v_'.urldecode($data['pass']).'_v');

    $ex = new Explorer();
    if ($ex->login($email, $pass)){
      $ret['auth'] = stGeneral::generateAuth();

      $ex->set('auth', $ret['auth']);
      $ex->save();
    }
    else{
      $ret['status'] = 'error';
    }
    
    return $ret;
  }
  
  // https://github.com/Flynsarmy/PHPWebSocket-Chat/blob/master/server.php
  // https://github.com/ghedipunk/PHP-Websockets/issues/41