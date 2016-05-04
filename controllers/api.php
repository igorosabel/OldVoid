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
    
    $id_user          = 0;
    $name             = '';
    $auth             = '';
    $credits          = 0;
    $last_save_point  = 0;
    $current_ship     = 0;
    $system_name      = '';
    $system_type      = '';
    $system_planets   = 0;
    $system_explorers = 0;
    $system_npc       = 0;
    $ship_strength    = 0;
    $ship_fuel        = 0;

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

        $ex->loadData();

        $ship = $ex->getShip();
        $system = $ex->getSystem();
        $system->loadNumExplorers();

        $system_name      = $system->get('name');
        $system_type      = $system->get('sun_type');
        $system_planets   = $system->get('num_planets');
        $system_explorers = $system->getNumExplorers();
        $system_npc       = $system->get('num_npc');
        $ship_strength    = $ship->get('hull_current_strength');
        $ship_fuel        = $ship->get('engine_fuel_actual');
        
        $id_user          = $ex->get('id');
        $name             = $ex->get('name');
        $credits          = $ex->get('credits');
        $last_save_point  = $ex->get('last_save_point');
        $current_ship     = $ex->get('current_ship');
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
    $t->add('current_ship',$current_ship);
    $t->add('email',$email);
    $t->add('system_name',$system_name);
    $t->add('system_type',$system_type);
    $t->add('system_planets',$system_planets);
    $t->add('system_explorers',$system_explorers);
    $t->add('system_npc',$system_npc);
    $t->add('ship_strength',$ship_strength);
    $t->add('ship_fuel',$ship_fuel);

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
    
    $id_user          = 0;
    $auth             = '';
    $credits          = 0;
    $last_save_point  = 0;
    $current_ship     = 0;
    $system_name      = '';
    $system_type      = '';
    $system_planets   = 0;
    $system_explorers = 0;
    $system_npc       = 0;
    $ship_strength    = 0;
    $ship_fuel        = 0;

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

      // Creo el usuario
      $ex = new G_Explorer();
      $ex->set('name',$name);
      $ex->set('email',$email);
      $ex->set('pass',$pass);
      $ex->set('credits',$credits);
      $ex->set('auth',$auth);
      
      $ex->salvar();
      
      $id_user = $ex->get('id');

      // Creo una nueva nave Scout
      $ship = General::generateShip($ex);
      $current_ship = $ship->get('id');
      $ex->set('current_ship',$current_ship);

      
      // Genero un sistema nuevo para él
      $system = General::generateSystem($ex);
      $last_save_point = $system->get('id');
      $ex->set('last_save_point',$last_save_point);
      $ex->salvar();
      
      $ex->loadData();

      $ship = $ex->getShip();
      $system = $ex->getSystem();
      $system->loadNumExplorers();

      $system_name      = $system->get('name');
      $system_type      = $system->get('sun_type');
      $system_planets   = $system->get('num_planets');
      $system_explorers = $system->getNumExplorers();
      $system_npc       = $system->get('num_npc');
      $ship_strength    = $ship->get('hull_current_strength');
      $ship_fuel        = $ship->get('engine_fuel_actual');
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status',$status);
    $t->add('id_user',$id_user);
    $t->add('name',$name);
    $t->add('email',$email);
    $t->add('credits',$credits);
    $t->add('last_save_point',$last_save_point);
    $t->add('current_ship',$current_ship);
    $t->add('auth',$auth);
    $t->add('system_name',$system_name);
    $t->add('system_type',$system_type);
    $t->add('system_planets',$system_planets);
    $t->add('system_explorers',$system_explorers);
    $t->add('system_npc',$system_npc);
    $t->add('ship_strength',$ship_strength);
    $t->add('ship_fuel',$ship_fuel);

    $t->process();
  }