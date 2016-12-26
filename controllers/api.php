<?php
  /*
   * Función para comprobar un login de un usuario
   */
  function executeLogin($req, $t){
    global $c, $s;

    $status = 'ok';
    $email  = Base::getParam('email', $req['url_params'], false);
    $pass   = Base::getParam('pass',  $req['url_params'], false);

    $auth   = '';

    if ($email===false || $pass===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $email = urldecode($email);
      $pass  = sha1('v_'.urldecode($pass).'_v');

      $ex = new Explorer();
      if ($ex->login($email, $pass)){
        $auth = stGeneral::generateAuth();

        $ex->set('auth', $auth);
        $ex->save();
      }
      else{
        $status = 'error';
      }
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status', $status);
    $t->add('auth',   $auth);

    $t->process();
  }
  
  /*
   * Función para registrar un nuevo usuario
   */
  function executeRegister($req, $t){
    global $c, $s;

    $status = 'ok';
    $name   = Base::getParam('name',  $req['url_params'], false);
    $email  = Base::getParam('email', $req['url_params'], false);
    $pass   = Base::getParam('pass',  $req['url_params'], false);
    
    $auth             = '';
    $credits          = 0;
    $current_ship     = 0;
    $last_save_point  = 0;

    if ($name===false || $email===false || $pass===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $name  = urldecode($name);
      $email = urldecode($email);
      $pass  = sha1('v_'.urldecode($pass).'_v');
      
      $auth    = stGeneral::generateAuth();
      $common  = Base::getCache('common');
      $credits = $common['credits'];

      // Creo el usuario
      $ex = new Explorer();
      $ex->set('name',    $name);
      $ex->set('email',   $email);
      $ex->set('pass',    $pass);
      $ex->set('credits', $credits);
      $ex->set('auth',    $auth);
      
      $ex->save();

      // Creo una nueva nave Scout
      $ship = stShip::generateShip($ex);
      $current_ship = $ship->get('id');
      $ex->set('current_ship', $current_ship);

      
      // Genero un sistema nuevo para él
      $system = stSystem::generateSystem($ex);
      $last_save_point = $system->get('id');
      $ex->set('last_save_point', $last_save_point);
      $ex->save();
      
      $ex->loadData();
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status', $status);
    $t->add('auth',   $auth);

    $t->process();
  }

  /*
   * Función para validar un auth y obtener los datos de un explorador
   */
  function executeCheckExplorer($req, $t){
    global $c, $s;

    $status          = 'ok';
    $auth            = Base::getParam('auth', $req['url_params'], false);

    $id              = 0;
    $name            = '';
    $credits         = 0;
    $current_ship    = 0;
    $last_save_point = 0;

    if ($auth===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $explorer = new Explorer();
      if ($explorer->find(array('auth'=>$auth))){
        $id              = $explorer->get('id');
        $name            = $explorer->get('name');
        $credits         = $explorer->get('credits');
        $current_ship    = $explorer->get('current_ship');
        $last_save_point = $explorer->get('last_save_point');
      }
      else{
        $status = 'error';
      }
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status',          $status);
    $t->add('id',              $id);
    $t->add('name',            $name);
    $t->add('credits',         $credits);
    $t->add('current_ship',    $current_ship);
    $t->add('last_save_point', $last_save_point);

    $t->process();
  }

  /*
   * Función para obtener los datos de un sistema
   */
  function executeGetSystem($req, $t){
    global $c, $s;

    $status = 'ok';
    $id     = Base::getParam('id',   $req['url_params'], false);
    $auth   = Base::getParam('auth', $req['url_params'], false);
    
    $system = array(
      'id'            => 0,
      'name'          => '',
      'type'          => '',
      'radius'        => 0,
      'id_discoverer' => 0,
      'discoverer'    => '',
      'planets'       => 0,
      'explorers'     => 0,
      'npc'           => 0,
      'planet_list'   => array()
    );

    if ($id===false || $auth===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $explorer = new Explorer();
      if ($explorer->find(array('auth'=>$auth))) {
        // Compruebo si está haciendo un trabajo
        if ($explorer->get('id_job')){
          $job = stJob::checkJob($explorer->get('id_job'));

          // Compruebo si el trabajo está terminado
          if ($job->getStatus()==stJob::STATUS_FINISHED){
            $job->jobDone();
            $explorer->set('id_job', null);
            $explorer->save();
          }
          else{
            $status = 'working';
          }
        }

        if ($status=='ok'){
          $sys = new System();
          if ($sys->find(array('id' => $id))) {
            $sys->loadNumExplorers();
            $system['id']            = $id;
            $system['name']          = $sys->get('name');
            $system['id_discoverer'] = $sys->get('id_discoverer');
            $system['discoverer']    = stSystem::getSystemDiscoverer($sys->get('id_discoverer'));
            $system['type']          = $sys->get('sun_type');
            $system['type_name']     = stSystem::getSystemTypeName($sys->get('sun_type'));
            $system['color']         = stSystem::getSystemColor($sys->get('sun_type'));
            $system['radius']        = $sys->get('sun_radius');
            $system['planets']       = $sys->get('num_planets');
            $system['explorers']     = $sys->getNumExplorers();
            $system['npc']           = $sys->get('num_npc');

            $system['planet_list']   = stSystem::loadPlanets($explorer, $sys);
            $system['connections']   = stSystem::loadSystemConnections($explorer, $sys);
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

    $t->add('status', $status);
    $t->addPartial('system', 'api/system', array('system'=>$system, 'extra'=>'nourlencode'));

    $t->process();
  }

  /*
   * Función para obtener las notificaciones de un usuario
  */
  function executeGetNotifications($req, $t){
    global $c, $s;

    $status = 'ok';
    $auth   = Base::getParam('auth', $req['url_params'], false);
    $notifications = array();

    if ($auth===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $explorer = new Explorer();
      if ($explorer->find(array('auth'=>$auth))){
        $notifications = stGeneral::getNotifications($explorer);
      }
      else{
        $status = 'error';
      }
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status', $status);
    $t->addPartial('notifications', 'api/notifications', array('notifications'=>$notifications, 'extra'=>'nourlencode'));

    $t->process();
  }

  /*
   * Función para obtener los exploradores y NPCs de un sistema
   */
  function executeGetPeopleInSystem($req, $t){
    global $c, $s;

    $status = 'ok';
    $id     = Base::getParam('id',   $req['url_params'], false);
    $auth   = Base::getParam('auth', $req['url_params'], false);

    $people_in_system = array('npc'=>array(), 'explorer'=>array());

    if ($id===false || $auth===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $explorer = new Explorer();
      if ($explorer->find(array('auth'=>$auth))) {
        $people_in_system = stSystem::getPeopleInSystem($id);
      }
      else{
        $status = 'error';
      }
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status', $status);
    $t->addPartial('people_in_system', 'api/people_in_system', array('people_in_system'=>$people_in_system, 'extra'=>'nourlencode'));

    $t->process();
  }

  /*
   * Función para explorar un planeta o una luna
   */
  function executeExplore($req, $t){
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
      $explorer = new Explorer();
      if ($explorer->find(array('auth'=>$auth))) {
        
        if ($explorer->get('id_job')){
          $job = stJob::checkJob($explorer->get('id_job'));
          
          if ($job->getStatus()==stJob::STATUS_FINISHED){
            $job->jobDone();
            $explorer->set('id_job', null);
            $explorer->save();
          }
          else{
            $status = 'working';
          }
        }
        
        if ($status=='ok'){
          $name   = '';
          if ($type=='planet'){
            $pl = new Planet();
            $pl->find(array('id'=>$id));
            $name = $pl->get('name');
            $explore_time = $pl->get('explore_time');
          }
          if ($type=='moon'){
            $mo = new Moon();
            $mo->find(array('id'=>$id));
            $name = $mo->get('name');
            $explore_time = $mo->get('explore_time');
          }
          $job = new Job();
          $job->set('id_explorer', $explorer->get('id'));
          $job->set('type',        stJob::EXPLORE);
          $job->set('value',       json_encode(array('type'=>$type, 'id'=>$id, 'name'=>$name)));
          $job->set('start',       time());
          $job->set('duration',    $explore_time);
          $job->save();

          $explorer->set('id_job', $job->get('id'));
          $explorer->save();
        }
      }
      else{
        $status = 'error';
      }
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status', $status);
    $t->addPartial('job', 'api/job', array('job'=>$job, 'extra'=>'nourlencode'));

    $t->process();
  }
  
  /*
   * Función para obtener recursos de un planeta o una luna
   */
  function executeGetResources($req, $t){
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
      $explorer = new Explorer();
      if ($explorer->find(array('auth'=>$auth))) {
        if ($explorer->get('id_job')){
          $job = stJob::checkJob($explorer->get('id_job'));
          
          if ($job->getStatus()==stJob::STATUS_FINISHED){
            $job->jobDone();
            $explorer->set('id_job', null);
            $explorer->save();
          }
          else{
            $status = 'working';
          }
        }
        
        if ($status=='ok'){
          $name   = '';
          if ($type=='planet'){
            $pl = new Planet();
            $pl->find(array('id'=>$id));
            $name = $pl->get('name');
            $explore_time = $pl->get('explore_time');
          }
          if ($type=='moon'){
            $mo = new Moon();
            $mo->find(array('id'=>$id));
            $name = $mo->get('name');
            $explore_time = $mo->get('explore_time');
          }
          $job = new Job();
          $job->set('id_explorer', $explorer->get('id'));
          $job->set('type',        stJob::RESOURCES);
          $job->set('value',       json_encode(array('type'=>$type, 'id'=>$id, 'name'=>$name)));
          $job->set('start',       time());
          $job->set('duration',    $explore_time);
          $job->save();

          $explorer->set('id_job', $job->get('id'));
          $explorer->save();
        }
      }
      else{
        $status = 'error';
      }
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status', $status);
    $t->addPartial('job', 'api/job', array('job'=>$job, 'extra'=>'nourlencode'));

    $t->process();
  }

  /*
   * Función para viajar a otro sistema
   */
  function executeGoToSystem($req, $t){
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
      $explorer = new Explorer();
      if ($explorer->find(array('auth'=>$auth))) {

        if ($explorer->get('id_job')){
          $job = stJob::checkJob($explorer->get('id_job'));

          if ($job->getStatus()==stJob::STATUS_FINISHED){
            $job->jobDone();
            $explorer->set('id_job', null);
            $explorer->save();
          }
          else{
            $status = 'working';
          }
        }

        if ($status=='ok'){
          $from = new System();
          $from->find(array('id'=>$explorer->get('last_save_point')));
          $system = stSystem::goToSystem($explorer, $from, $id);

          $job = new Job();
          $job->set('id_explorer', $explorer->get('id'));
          $job->set('type',        stJob::JUMP);
          $job->set('value',       json_encode(array('id'=>$system->get('id'), 'name'=>($id ? $system->get('name') : 'Desconocido'))));
          $job->set('start',       time());
          $job->set('duration',    $time);
          $job->save();

          $explorer->set('id_job', $job->get('id'));
          $explorer->save();
        }
      }
      else{
        $status = 'error';
      }
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status', $status);
    $t->addPartial('job', 'api/job', array('job'=>$job, 'extra'=>'nourlencode'));

    $t->process();
  }

  /*
   * Función para obtener los datos de la nave actual
   */
  function executeGetShip($req, $t){
    global $c, $s;

    $status = 'ok';
    $auth   = Base::getParam('auth', $req['url_params'], false);
    $ship   = false;

    if ($auth===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $explorer = new Explorer();
      if ($explorer->find(array('auth'=>$auth))) {
        $ship = stShip::loadShip($explorer);
      }
      else{
        $status = 'error';
      }
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status', $status);
    $t->addPartial('ship', 'api/ship', array('ship'=>$ship, 'extra'=>'nourlencode'));

    $t->process();
  }

  /*
   * Función para obtener los datos de la nave actual
   */
  function executeChangeShipName($req, $t){
    global $c, $s;

    $status = 'ok';
    $name   = Base::getParam('name', $req['url_params'], false);
    $auth   = Base::getParam('auth', $req['url_params'], false);

    if ($name===false || $auth===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $explorer = new Explorer();
      if ($explorer->find(array('auth'=>$auth))) {
        $ship = new Ship();
        $ship->find(array('id'=>$explorer->get('current_ship')));

        $ship->set('name',urldecode($name));
        $ship->save();
      }
      else{
        $status = 'error';
      }
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status', $status);

    $t->process();
  }