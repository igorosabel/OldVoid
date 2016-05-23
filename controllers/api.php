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
      'id' => 0,
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
        $system['discoverer']    = System::getSystemDiscoverer($sys->get('id_discoverer'));
        $system['type']          = $sys->get('sun_type');
        $system['type_name']     = System::getSystemTypeName($sys->get('sun_type'));
        $system['color']         = System::getSystemColor($sys->get('sun_type'));
        $system['radius']        = $sys->get('sun_radius');
        $system['planets']       = $sys->get('num_planets');
        $system['explorers']     = $sys->getNumExplorers();
        $system['npc']           = $sys->get('num_npc');
        
        $system['planet_list']   = System::loadPlanets($ex,$sys);
        $system['connections']   = System::loadSystemConnections($ex,$sys);

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
    $t->add('name',$name);
    $t->add('auth',$auth);
    $t->add('credits',$credits);
    $t->add('email',$email);
    $t->add('current_ship',$current_ship);
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
    $ship_strength    = 0;
    $ship_fuel        = 0;
    $system = array(
      'id' => 0,
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

    if ($name===false || $email===false || $pass===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $name  = urldecode($name);
      $email = urldecode($email);
      $pass  = sha1('v_'.urldecode($pass).'_v');
      
      $auth    = General::generateAuth();
      $common  = Base::getCache('common');
      $credits = $common['credits'];

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
      $sys = $ex->getSystem();
      $sys->loadNumExplorers($ex);

      $system['id']            = $sys->get('id');
      $system['name']          = $sys->get('name');
      $system['id_discoverer'] = $sys->get('id_discoverer');
      $system['discoverer']    = System::getSystemDiscoverer($sys->get('id_discoverer'));
      $system['type']          = $sys->get('sun_type');
      $system['color']         = System::getSystemColor($sys->get('sun_type'));
      $system['radius']        = $sys->get('sun_radius');
      $system['planets']       = $sys->get('num_planets');
      $system['explorers']     = $sys->getNumExplorers();
      $system['npc']           = $sys->get('num_npc');

      $system['planet_list']   = System::loadPlanets($ex,$sys);
      $system['connections']   = System::loadSystemConnections($ex,$sys);

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
    $t->add('current_ship',$current_ship);
    $t->add('auth',$auth);
    $t->add('ship_strength',$ship_strength);
    $t->add('ship_fuel',$ship_fuel);
    $t->addPartial('system','api/system',array('system'=>$system,'extra'=>'nourlencode'));

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
    $id     = Base::getParam('id',   $req['url_params'], false);
    $auth   = Base::getParam('auth', $req['url_params'], false);
    
    $system = array(
      'id' => 0,
      'name' => '',
      'type' => '',
      'radius' => 0,
      'id_discoverer' => 0,
      'discoverer' => '',
      'planets' => 0,
      'explorers' => 0,
      'npc' => 0,
      'planet_list' => array()
    );

    if ($id===false || $auth===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $explorer = new G_Explorer();
      if ($explorer->buscar(array('auth'=>$auth))) {
        // Compruebo si está haciendo un trabajo
        if ($explorer->get('id_job')){
          $job = Job::checkJob($explorer->get('id_job'));

          // Compruebo si el trabajo está terminado
          if ($job->getStatus()==Job::STATUS_FINISHED){
            $job->jobDone();
            $explorer->set('id_job',null);
            $explorer->salvar();
          }
          else{
            $status = 'working';
          }
        }

        if ($status=='ok'){
          $sys = new G_System();
          if ($sys->buscar(array('id' => $id))) {
            $sys->loadNumExplorers();
            $system['id'] = $id;
            $system['name'] = $sys->get('name');
            $system['id_discoverer'] = $sys->get('id_discoverer');
            $system['discoverer'] = System::getSystemDiscoverer($sys->get('id_discoverer'));
            $system['type'] = $sys->get('sun_type');
            $system['color'] = System::getSystemColor($sys->get('sun_type'));
            $system['radius'] = $sys->get('sun_radius');
            $system['planets'] = $sys->get('num_planets');
            $system['explorers'] = $sys->getNumExplorers();
            $system['npc'] = $sys->get('num_npc');

            $system['planet_list'] = System::loadPlanets($explorer, $sys);
            $system['connections'] = System::loadSystemConnections($explorer, $sys);
          } else {
            $status = 'error';
          }
        }
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
    $auth   = Base::getParam('auth', $req['url_params'], false);

    $notifications = array();

    if ($auth===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $explorer = new G_Explorer();
      if ($explorer->buscar(array('auth'=>$auth))){
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
    $id     = Base::getParam('id',   $req['url_params'], false);
    $auth   = Base::getParam('auth', $req['url_params'], false);

    $people_in_system = array('npc'=>array(),'explorer'=>array());

    if ($id===false || $auth===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $explorer = new G_Explorer();
      if ($explorer->buscar(array('auth'=>$auth))) {
        $people_in_system = System::getPeopleInSystem($id);
      }
      else{
        $status = 'error';
      }
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status',$status);
    $t->addPartial('people_in_system','api/people_in_system',array('people_in_system'=>$people_in_system,'extra'=>'nourlencode'));

    $t->process();
  }

  /*
    Función para explorar un planeta o una luna
  */
  function executeExplore($req, $t){
    /*
      Código de la página
    */
    global $c, $s;

    $status = 'ok';
    $id     = Base::getParam('id',   $req['url_params'], false);
    $type   = Base::getParam('type', $req['url_params'], false);
    $auth   = Base::getParam('auth', $req['url_params'], false);
    
    $job    = false;

    if ($id===false || $type===false || $auth===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $explorer = new G_Explorer();
      if ($explorer->buscar(array('auth'=>$auth))) {
        
        if ($explorer->get('id_job')){
          $job = Job::checkJob($explorer->get('id_job'));
          
          if ($job->getStatus()==Job::STATUS_FINISHED){
            $job->jobDone();
            $explorer->set('id_job',null);
            $explorer->salvar();
          }
          else{
            $status = 'working';
          }
        }
        
        if ($status=='ok'){
          $name   = '';
          if ($type=='planet'){
            $pl = new G_Planet();
            $pl->buscar(array('id'=>$id));
            $name = $pl->get('name');
            $explore_time = $pl->get('explore_time');
          }
          if ($type=='moon'){
            $mo = new G_Moon();
            $mo->buscar(array('id'=>$id));
            $name = $mo->get('name');
            $explore_time = $mo->get('explore_time');
          }
          $job = new G_Job();
          $job->set('id_explorer',$explorer->get('id'));
          $job->set('type',Job::EXPLORE);
          $job->set('value','{"type":"'.$type.'","id":'.$id.',"name":"'.$name.'"}');
          $job->set('start',time());
          $job->set('duration',$explore_time);
          $job->salvar();

          $explorer->set('id_job',$job->get('id'));
          $explorer->salvar();
        }
      }
      else{
        $status = 'error';
      }
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status',$status);
    $t->addPartial('job','api/job',array('job'=>$job,'extra'=>'nourlencode'));

    $t->process();
  }
  
  /*
    Función para obtener recursos de un planeta o una luna
  */
  function executeGetResources($req, $t){
    /*
      Código de la página
    */
    global $c, $s;

    $status = 'ok';
    $id     = Base::getParam('id',   $req['url_params'], false);
    $type   = Base::getParam('type', $req['url_params'], false);
    $auth   = Base::getParam('auth', $req['url_params'], false);
    
    $job    = false;

    if ($id===false || $type===false || $auth===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $explorer = new G_Explorer();
      if ($explorer->buscar(array('auth'=>$auth))) {
        
        if ($explorer->get('id_job')){
          $job = Job::checkJob($explorer->get('id_job'));
          
          if ($job->getStatus()==Job::STATUS_FINISHED){
            $job->jobDone();
            $explorer->set('id_job',null);
            $explorer->salvar();
          }
          else{
            $status = 'working';
          }
        }
        
        if ($status=='ok'){
          $name   = '';
          if ($type=='planet'){
            $pl = new G_Planet();
            $pl->buscar(array('id'=>$id));
            $name = $pl->get('name');
            $explore_time = $pl->get('explore_time');
          }
          if ($type=='moon'){
            $mo = new G_Moon();
            $mo->buscar(array('id'=>$id));
            $name = $mo->get('name');
            $explore_time = $mo->get('explore_time');
          }
          $job = new G_Job();
          $job->set('id_explorer',$explorer->get('id'));
          $job->set('type',Job::RESOURCES);
          $job->set('value','{"type":"'.$type.'","id":'.$id.',"name":"'.$name.'"}');
          $job->set('start',time());
          $job->set('duration',$explore_time);
          $job->salvar();

          $explorer->set('id_job',$job->get('id'));
          $explorer->salvar();
        }
      }
      else{
        $status = 'error';
      }
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status',$status);
    $t->addPartial('job','api/job',array('job'=>$job,'extra'=>'nourlencode'));

    $t->process();
  }

  /*
    Función para viajar a otro sistema
  */
  function executeGoToSystem($req, $t){
    /*
      Código de la página
    */
    global $c, $s;

    $status = 'ok';
    $id     = Base::getParam('id',   $req['url_params'], null);
    $time   = Base::getParam('time', $req['url_params'], false);
    $auth   = Base::getParam('auth', $req['url_params'], false);

    $job    = false;

    if ($time===false || $auth===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $explorer = new G_Explorer();
      if ($explorer->buscar(array('auth'=>$auth))) {

        if ($explorer->get('id_job')){
          $job = Job::checkJob($explorer->get('id_job'));

          if ($job->getStatus()==Job::STATUS_FINISHED){
            $job->jobDone();
            $explorer->set('id_job',null);
            $explorer->salvar();
          }
          else{
            $status = 'working';
          }
        }

        if ($status=='ok'){
          $from = new G_System();
          $from->buscar(array('id'=>$explorer->get('last_save_point')));
          $system = System::goToSystem($explorer,$from,$id);

          $job = new G_Job();
          $job->set('id_explorer',$explorer->get('id'));
          $job->set('type',Job::JUMP);
          $job->set('value','{"id":'.$system->get('id').',"name":"'.($id?$system->get('name'):'Desconocido').'"}');
          $job->set('start',time());
          $job->set('duration',$time);
          $job->salvar();

          $explorer->set('id_job',$job->get('id'));
          $explorer->salvar();
        }
      }
      else{
        $status = 'error';
      }
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status',$status);
    $t->addPartial('job','api/job',array('job'=>$job,'extra'=>'nourlencode'));

    $t->process();
  }

  /*
    Función para obtener los datos de la nave actual
  */
  function executeGetShip($req, $t){
    /*
      Código de la página
    */
    global $c, $s;

    $status = 'ok';
    $auth   = Base::getParam('auth', $req['url_params'], false);
    $ship   = false;

    if ($auth===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $explorer = new G_Explorer();
      if ($explorer->buscar(array('auth'=>$auth))) {
        $ship = Ship::loadShip($explorer);
      }
      else{
        $status = 'error';
      }
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status',$status);
    $t->addPartial('ship','api/ship',array('ship'=>$ship,'extra'=>'nourlencode'));

    $t->process();
  }