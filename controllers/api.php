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
    $current_ship     = 0;
    $ship_strength    = 0;
    $ship_fuel        = 0;
    $system = array(
      'name' => '',
      'type' => '',
      'id_discoverer' => 0,
      'discoverer' => '',
      'planets' => 0,
      'explorers ' => 0,
      'npc' => 0,
      'planet_list' => array(),
      'connections' => array()
    );

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
        $sys = $ex->getSystem();
        $sys->loadNumExplorers($ex);
        
        $system['id']            = $sys->get('id');
        $system['name']          = $sys->get('name');
        $system['id_discoverer'] = $sys->get('id_discoverer');
        $system['type']          = $sys->get('sun_type');
        $system['color']         = System::getSystemColor($sys->get('sun_type'));
        $system['radius']        = $sys->get('sun_radius');
        $system['planets']       = $sys->get('num_planets');
        $system['explorers']     = $sys->getNumExplorers();
        $system['npc']           = $sys->get('num_npc');
        
        $system['planet_list']   = System::loadPlanets($sys);
        $system['connections']   = System::loadSystemConnections($ex,$sys);
        
        $disc = new G_Explorer();
        $discoverer = '';
        if ($disc->buscar(array('id'=>$sys->get('id_discoverer')))){
          $discoverer = $disc->get('name');
        }
        $system['discoverer']    = $discoverer;

        $ship_strength    = $ship->get('hull_current_strength');
        $ship_fuel        = $ship->get('engine_fuel_actual');
        
        $id_user          = $ex->get('id');
        $name             = $ex->get('name');
        $credits          = $ex->get('credits');
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
    $t->add('id_discoverer',$id_discoverer);
    $t->add('discoverer',$discoverer);
    $t->add('name',$name);
    $t->add('auth',$auth);
    $t->add('credits',$credits);
    $t->add('current_ship',$current_ship);
    $t->add('email',$email);
    $t->add('ship_strength',$ship_strength);
    $t->add('ship_fuel',$ship_fuel);
    $t->addPartial('system','api/system',array('system'=>$system,'extra'=>'nourlencode'));

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
      $ship = Ship::generateShip($ex);
      $current_ship = $ship->get('id');
      $ex->set('current_ship',$current_ship);

      
      // Genero un sistema nuevo para él
      $system = System::generateSystem($ex);
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

  /*
    Función para obtener los datos de un sistema
  */
  function executeGetSystem($req, $t){
    /*
      Código de la página
    */
    global $c, $s;

    $status = 'ok';
    $id     = Base::getParam('id', $req['url_params'], false);
    
    $system = array(
      'name' => '',
      'type' => '',
      'id_discoverer' => 0,
      'discoverer' => '',
      'planets' => 0,
      'explorers ' => 0,
      'npc' => 0,
      'planet_list' => array()
    );

    if ($id===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $sys = new G_System();
      if ($sys->buscar(array('id'=>$id))){
        $sys->loadNumExplorers();
        $system['id']            = $id;
        $system['name']          = $sys->get('name');
        $system['id_discoverer'] = $sys->get('id_discoverer');
        $system['discoverer']    = '';
        $system['type']          = $sys->get('sun_type');
        $system['color']         = System::getSystemColor($sys->get('sun_type'));
        $system['radius']        = $sys->get('sun_radius');
        $system['planets']       = $sys->get('num_planets');
        $system['explorers']     = $sys->getNumExplorers();
        $system['npc']           = $sys->get('num_npc');
        
        $system['planet_list']   = System::loadPlanets($sys);
      }
      else{
        $status = 'error';
      }
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status',$status);
    $t->addPartial('system','api/system',array('system'=>$system,'extra'=>'nourlencode'));

    $t->process();
  }

  /*
    Función para obtener las notificaciones de un usuario
  */
  function executeGetNotifications($req, $t){
    /*
      Código de la página
    */
    global $c, $s;

    $status = 'ok';
    $id     = Base::getParam('id', $req['url_params'], false);

    $notifications = array();

    if ($id===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $explorer = new G_Explorer();
      if ($explorer->buscar(array('id'=>$id))){
        $notifications = General::getNotifications($explorer);
      }
      else{
        $status = 'error';
      }
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status',$status);
    $t->addPartial('notifications','api/notifications',array('notifications'=>$notifications,'extra'=>'nourlencode'));

    $t->process();
  }

  /*
    Función para obtener los exploradores y NPCs de un sistema
  */
  function executeGetPeopleInSystem($req, $t){
    /*
      Código de la página
    */
    global $c, $s;

    $status = 'ok';
    $id     = Base::getParam('id', $req['url_params'], false);

    $people_in_system = array('npc'=>array(),'explorer'=>array());

    if ($id===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $people_in_system = System::getPeopleInSystem($id);
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status',$status);
    $t->addPartial('people_in_system','api/people_in_system',array('people_in_system'=>$people_in_system,'extra'=>'nourlencode'));

    $t->process();
  }