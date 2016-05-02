<?php
  /*
    Función para comprobar un login de un usuario
  */
  function executeLogin($req, $t){
    /*
      Código de la página
    */
    global $c, $s;

    $status = 'ok';
    $email  = Base::getParam('email', $req['url_params'], false);
    $pass   = Base::getParam('pass',  $req['url_params'], false);
    
    $id_user         = 0;
    $name            = '';
    $auth            = '';
    $credits         = 0;
    $last_save_point = 0;

    if ($email===false || $pass===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $email = urldecode($email);
      $pass  = sha1('v_'.urldecode($pass).'_v');

      $ex = new G_Explorer();
      if ($ex->login($email,$pass)){
        $auth = General::generateAuth();

        $ex->set('auth',$auth);
        $ex->salvar();
        
        $id_user         = $ex->get('id');
        $name            = $ex->get('name');
        $credits         = $ex->get('credits');
        $last_save_point = $ex->get('last_save_point');
      }
      else{
        $status = 'error';
      }
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status',$status);
    $t->add('id_user',$id_user);
    $t->add('name',$name);
    $t->add('auth',$auth);
    $t->add('credits',$credits);
    $t->add('last_save_point',$last_save_point);
    $t->add('email',$email);

    $t->process();
  }
  
  /*
    Función para registrar un nuevo usuario
  */
  function executeRegister($req, $t){
    /*
      Código de la página
    */
    global $c, $s;

    $status = 'ok';
    $name   = Base::getParam('name',  $req['url_params'], false);
    $email  = Base::getParam('email', $req['url_params'], false);
    $pass   = Base::getParam('pass',  $req['url_params'], false);
    
    $id_user         = 0;
    $auth            = '';
    $credits         = 0;
    $last_save_point = 0;

    if ($name===false || $email===false || $pass===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $name  = urldecode($name);
      $email = urldecode($email);
      $pass  = sha1('v_'.urldecode($pass).'_v');
      
      $auth  = General::generateAuth();
      $start = Base::getCache('start');
      $credits = $start['credits'];

      // Creo una nueva nave Scout

      // Creo el usuario
      $ex = new G_Explorer();
      $ex->set('name',$name);
      $ex->set('email',$email);
      $ex->set('pass',$pass);
      $ex->set('credits',$credits);
      $ex->set('auth',$auth);
      
      $ex->salvar();
      
      $id_user = $ex->get('id');
      
      // Genero un sistema nuevo para él
      $system = General::generateSystem($ex);
      $last_save_point = $system->get('id');
      $ex->set('last_save_point',$last_save_point);
      $ex->salvar();
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status',$status);
    $t->add('id_user',$id_user);
    $t->add('name',$name);
    $t->add('email',$email);
    $t->add('credits',$credits);
    $t->add('last_save_point',$last_save_point);
    $t->add('auth',$auth);

    $t->process();
  }