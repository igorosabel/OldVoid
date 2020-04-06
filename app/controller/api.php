<?php
class api extends OController{
  private $general_service = null;
  private $ship_service = null;
  private $system_service = null;
  private $job_service = null;
  public $npc_service = null;

  function __construct(){
    $this->general_service = new generalService();
    $this->ship_service = new shipService();
    $this->system_service = new systemService();
    $this->job_service = new jobService();
    $this->npc_service = new npcService();
  }

  /*
   * Función para comprobar un login de un usuario
   */
  function login($req){
    $status = 'ok';
    $email  = OTools::getParam('email', $req['params'], false);
    $pass   = OTools::getParam('pass',  $req['params'], false);

    $auth   = '';

    if ($email===false || $pass===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $email = urldecode($email);
      $pass  = sha1('v_'.urldecode($pass).'_v');

      $ex = new Explorer();
      if ($ex->login($email, $pass)){
        $auth = $this->general_service->generateAuth();

        $ex->set('auth', $auth);
        $ex->save();
      }
      else{
        $status = 'error';
      }
    }

    $this->getTemplate()->add('status', $status);
    $this->getTemplate()->add('auth',   $auth);
  }

  /*
   * Función para registrar un nuevo usuario
   */
  function register($req){
    $status = 'ok';
    $name   = OTools::getParam('name',  $req['params'], false);
    $email  = OTools::getParam('email', $req['params'], false);
    $pass   = OTools::getParam('pass',  $req['params'], false);

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

      $auth    = $this->general_service->generateAuth();
      $common  = OTools::getCache('common');
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
      $ship = $this->ship_service->generateShip($ex);
      $current_ship = $ship->get('id');
      $ex->set('current_ship', $current_ship);

      // Genero un sistema nuevo para él
      $system = $this->system_service->generateSystem($ex);
      $last_save_point = $system->get('id');
      $ex->set('last_save_point', $last_save_point);
      $ex->save();

      $ex->loadData();
    }

    $this->getTemplate()->add('status', $status);
    $this->getTemplate()->add('auth',   $auth);
  }

  /*
   * Función para validar un auth y obtener los datos de un explorador
   */
  function checkExplorer($req){
    $status          = 'ok';
    $auth            = OTools::getParam('auth', $req['params'], false);

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
      if ($explorer->find(['auth'=>$auth])){
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

    $this->getTemplate()->add('status',          $status);
    $this->getTemplate()->add('id',              $id);
    $this->getTemplate()->add('name',            $name);
    $this->getTemplate()->add('credits',         $credits);
    $this->getTemplate()->add('current_ship',    $current_ship);
    $this->getTemplate()->add('last_save_point', $last_save_point);
  }

  /*
   * Función para obtener los datos de un sistema
   */
  function getSystem($req){
    $status = 'ok';
    $id     = OTools::getParam('id',   $req['params'], false);
    $auth   = OTools::getParam('auth', $req['params'], false);

    $system = [
      'id'            => 0,
      'name'          => '',
      'type'          => '',
      'radius'        => 0,
      'id_discoverer' => 0,
      'discoverer'    => '',
      'planets'       => 0,
      'explorers'     => 0,
      'npc'           => 0,
      'planet_list'   => []
    ];

    if ($id===false || $auth===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $explorer = new Explorer();
      if ($explorer->find(['auth'=>$auth])) {
        // Compruebo si está haciendo un trabajo
        if ($explorer->get('id_job')){
          $job = $this->job_service->checkJob($explorer->get('id_job'));

          // Compruebo si el trabajo está terminado
          if ($job->getStatus()==jobService::STATUS_FINISHED){
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
          if ($sys->find(['id' => $id])){
            $sys->loadNumExplorers();
            $system['id']            = $id;
            $system['name']          = $sys->get('name');
            $system['id_discoverer'] = $sys->get('id_discoverer');
            $system['discoverer']    = $this->system_service->getSystemDiscoverer($sys->get('id_discoverer'));
            $system['type']          = $sys->get('sun_type');
            $system['type_name']     = $this->system_service->getSystemTypeName($sys->get('sun_type'));
            $system['color']         = $this->system_service->getSystemColor($sys->get('sun_type'));
            $system['radius']        = $sys->get('sun_radius');
            $system['planets']       = $sys->get('num_planets');
            $system['explorers']     = $sys->getNumExplorers();
            $system['npc']           = $sys->get('num_npc');

            $system['planet_list']   = $this->system_service->loadPlanets($explorer, $sys);
            $system['connections']   = $this->system_service->loadSystemConnections($explorer, $sys);
          }
          else{
            $status = 'error';
          }
        }
      }
      else{
        $status = 'error';
      }
    }

    $this->getTemplate()->add('status', $status);
    $this->getTemplate()->addPartial('system', 'api/system', ['system'=>$system, 'system_service'=>$this->system_service, 'general_service'=>$this->general_service, 'extra'=>'nourlencode']);
  }

  /*
   * Función para obtener las notificaciones de un usuario
  */
  function getNotifications($req){
    $status = 'ok';
    $auth   = OTools::getParam('auth', $req['params'], false);
    $notifications = [];

    if ($auth===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $explorer = new Explorer();
      if ($explorer->find(['auth'=>$auth])){
        $notifications = $this->general_service->getNotifications($explorer);
      }
      else{
        $status = 'error';
      }
    }

    $this->getTemplate()->add('status', $status);
    $this->getTemplate()->addPartial('notifications', 'api/notifications', ['notifications'=>$notifications, 'extra'=>'nourlencode']);
  }

  /*
   * Función para obtener los exploradores y NPCs de un sistema
   */
  function getPeopleInSystem($req){
    $status = 'ok';
    $id     = OTools::getParam('id',   $req['params'], false);
    $auth   = OTools::getParam('auth', $req['params'], false);

    $people_in_system = array('npc'=>[], 'explorer'=>[]);

    if ($id===false || $auth===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $explorer = new Explorer();
      if ($explorer->find(['auth'=>$auth])) {
        $people_in_system = $this->system_service->getPeopleInSystem($id);
      }
      else{
        $status = 'error';
      }
    }

    $this->getTemplate()->add('status', $status);
    $this->getTemplate()->addPartial('people_in_system', 'api/people_in_system', ['people_in_system'=>$people_in_system, 'extra'=>'nourlencode']);
  }

  /*
   * Función para explorar un planeta o una luna
   */
  function explore($req){
    $status = 'ok';
    $id     = OTools::getParam('id',   $req['params'], false);
    $type   = OTools::getParam('type', $req['params'], false);
    $auth   = OTools::getParam('auth', $req['params'], false);
    $job    = false;

    if ($id===false || $type===false || $auth===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $explorer = new Explorer();
      if ($explorer->find(['auth'=>$auth])) {

        if ($explorer->get('id_job')){
          $job = $this->job_service->checkJob($explorer->get('id_job'));

          if ($job->getStatus()==jobService::STATUS_FINISHED){
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
            $pl->find(['id'=>$id]);
            $name = $pl->get('name');
            $explore_time = $pl->get('explore_time');
          }
          if ($type=='moon'){
            $mo = new Moon();
            $mo->find(['id'=>$id]);
            $name = $mo->get('name');
            $explore_time = $mo->get('explore_time');
          }
          $job = new Job();
          $job->set('id_explorer', $explorer->get('id'));
          $job->set('type',        jobService::EXPLORE);
          $job->set('value',       json_encode(['type'=>$type, 'id'=>$id, 'name'=>$name]));
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

    $this->getTemplate()->add('status', $status);
    $this->getTemplate()->addPartial('job', 'api/job', ['job'=>$job, 'extra'=>'nourlencode']);
  }

  /*
   * Función para obtener recursos de un planeta o una luna
   */
  function getResources($req){
    $status = 'ok';
    $id     = OTools::getParam('id',   $req['params'], false);
    $type   = OTools::getParam('type', $req['params'], false);
    $auth   = OTools::getParam('auth', $req['params'], false);

    $job    = false;

    if ($id===false || $type===false || $auth===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $explorer = new Explorer();
      if ($explorer->find(['auth'=>$auth])) {
        if ($explorer->get('id_job')){
          $job = $this->job_service->checkJob($explorer->get('id_job'));

          if ($job->getStatus()==jobService::STATUS_FINISHED){
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
            $pl->find(['id'=>$id]);
            $name = $pl->get('name');
            $explore_time = $pl->get('explore_time');
          }
          if ($type=='moon'){
            $mo = new Moon();
            $mo->find(['id'=>$id]);
            $name = $mo->get('name');
            $explore_time = $mo->get('explore_time');
          }
          $job = new Job();
          $job->set('id_explorer', $explorer->get('id'));
          $job->set('type',        jobService::RESOURCES);
          $job->set('value',       json_encode(['type'=>$type, 'id'=>$id, 'name'=>$name]));
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

    $this->getTemplate()->add('status', $status);
    $this->getTemplate()->addPartial('job', 'api/job', ['job'=>$job, 'extra'=>'nourlencode']);
  }

  /*
   * Función para viajar a otro sistema
   */
  function goToSystem($req){
    $status = 'ok';
    $id     = OTools::getParam('id',   $req['params'], null);
    $time   = OTools::getParam('time', $req['params'], false);
    $auth   = OTools::getParam('auth', $req['params'], false);
    $job    = false;

    if ($time===false || $auth===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $explorer = new Explorer();
      if ($explorer->find(['auth'=>$auth])) {

        if ($explorer->get('id_job')){
          $job = $this->job_service->checkJob($explorer->get('id_job'));

          if ($job->getStatus()==jobService::STATUS_FINISHED){
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
          $from->find(['id'=>$explorer->get('last_save_point')]);
          $system = $this->system_service->goToSystem($explorer, $from, $id);

          $job = new Job();
          $job->set('id_explorer', $explorer->get('id'));
          $job->set('type',        jobService::JUMP);
          $job->setJobName(        $this->job_service->getJobName(jobService::JUMP));
          $job->set('value',       json_encode(['id'=>$system->get('id'), 'name'=>($id ? $system->get('name') : 'Desconocido')]));
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

    $this->getTemplate()->add('status', $status);
    $this->getTemplate()->addPartial('job', 'api/job', ['job'=>$job, 'extra'=>'nourlencode']);
  }

  /*
   * Función para obtener los datos de la nave actual
   */
  function getShip($req){
    $status = 'ok';
    $auth   = OTools::getParam('auth', $req['params'], false);
    $ship   = false;

    if ($auth===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $explorer = new Explorer();
      if ($explorer->find(['auth'=>$auth])) {
        $ship = $this->ship_service->loadShip($explorer);
      }
      else{
        $status = 'error';
      }
    }

    $this->getTemplate()->add('status', $status);
    $this->getTemplate()->addPartial('ship', 'api/ship', ['ship'=>$ship, 'ship_service'=>$this->ship_service, 'general_service'=>$this->general_service, 'extra'=>'nourlencode']);
  }

  /*
   * Función para obtener los datos de la nave actual
   */
  function changeShipName($req){
    $status = 'ok';
    $name   = OTools::getParam('name', $req['params'], false);
    $auth   = OTools::getParam('auth', $req['params'], false);

    if ($name===false || $auth===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $explorer = new Explorer();
      if ($explorer->find(['auth'=>$auth])) {
        $ship = new Ship();
        $ship->find(['id'=>$explorer->get('current_ship')]);

        $ship->set('name',urldecode($name));
        $ship->save();
      }
      else{
        $status = 'error';
      }
    }

    $this->getTemplate()->add('status', $status);
  }
}