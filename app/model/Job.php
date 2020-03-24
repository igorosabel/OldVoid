<?php
class Job extends OModel{
  function __construct(){
    $table_name = 'job';
    $model = [
        'id' => [
          'type'    => OCore::PK,
          'comment' => 'Id único del trabajo'
        ],
        'id_explorer' => [
          'type'    => OCore::NUM,
          'comment' => 'Id del explorador que hace el trabajo'
        ],
        'type' => [
          'type'    => OCore::NUM,
          'comment' => 'Tipo de trabajo'
        ],
        'value' => [
          'type'    => OCore::LONGTEXT,
          'comment' => 'Información extra del trabajo'
        ],
        'start' => [
          'type'    => OCore::NUM,
          'comment' => 'Timestamp de la fecha de inicio'
        ],
        'duration' => [
          'type'    => OCore::NUM,
          'comment' => 'Duración del trabajo'
        ],
        'created_at' => [
          'type'    => OCore::CREATED,
          'comment' => 'Fecha de creación del registro'
        ],
        'updated_at' => [
          'type'    => OCore::UPDATED,
          'comment' => 'Fecha de última modificación del registro'
        ]
    ];

    parent::load($table_name, $model);
  }

  private $status = '';

  public function setStatus($s){
    $this->status = $s;
  }
  public function getStatus(){
    return $this->status;
  }

  public function jobDone(){
    if ($this->get('type')==jobService::EXPLORE){
      $this->jobDoneExplore();
    }
    if ($this->get('type')==jobService::RESOURCES){
      $this->jobDoneResources();
    }
    if ($this->get('type')==jobService::JUMP){
      $this->jobDoneJump();
    }
  }

  private function jobDoneExplore(){
    $data = json_decode($this->get('value'),true);
    $explored = new Explored();
    $explored->set('id_explorer',$this->get('id_explorer'));
    if ($data['type']=='planet') {
      $explored->set('id_moon', 0);
      $explored->set('id_planet', $data['id']);

      $pl = new Planet();
      $pl->find(['id'=>$data['id']]);
      if (!$pl->get('explored')){
        $pl->setExplored(true);
        $pl->save();
        systemService::generateResources('planet',$pl);
      }
    }
    if ($data['type']=='moon') {
      $explored->set('id_moon', $data['id']);
      $explored->set('id_planet', 0);

      $mo = new Moon();
      $mo->find(['id'=>$data['id']]);
      if (!$mo->get('explored')){
        $mo->setExplored(true);
        $mo->save();
        systemService::generateResources('moon',$mo);
      }
    }

    $explored->save();
  }

  private function jobDoneResources(){
    // Busco el explorador
    $explorer = new Explorer();
    $explorer->find(['id'=>$this->get('id_explorer')]);

    // Busco la nave del explorador
    $ship = new Ship();
    $ship->find(['id'=>$explorer->get('current_ship')]);

    // Cargo sus módulos
    $modules = shipService::loadModules($ship);
    $storage_module = null;

    // Busco el módulo de almacenamiento
    foreach ($modules as $module){
      if ($module->get('enables')==shipService::MODULE_STORAGE){
        $storage_module = $module;
      }
    }

    $free_space = $storage_module->get('storage_capacity');
    $explorer_resources = [];
    $explorer_resources_ind = [];

    // Calculo espacio libre en el módulo
    if (!is_null($storage_module->get('storage'))){
      $module_data = json_decode($storage_module->get('storage'),true);
      foreach ($module_data as $ind=>$module_obj){
        // Espacio total menos lo que ya lleva
        $free_space -= $module_obj['value'];
        $explorer_resources[$module_obj['resource_id']] = $module_obj['value'];
        $explorer_resources_ind['resource_'.$module_obj['resource_id']] = $ind;
      }
    }

    // Cojo datos del trabajo
    $data = json_decode($this->get('value'), true);

    // Cojo el planeta o la luna
    if ($data['type']=='planet'){
      $obj = new Planet();
      $obj->find(['id'=>$data['id']]);
    }
    if ($data['type']=='moon'){
      $obj = new Moon();
      $obj->find(['id'=>$data['id']]);
    }

    // Cargo recursos del planeta o luna
    $obj->setResources(systemService::loadResources($obj, $data['type']));

    $obj_resources = $obj->getResources();
    $total_resources = 0;

    // El jugador obtiene un 10% de cada recurso que hay en el planeta
    for ($i=0;$i<count($obj_resources);$i++){
      $resource_id    = $obj_resources[$i]->get('id_resource_type');
      $resource_value = floor((int)$obj_resources[$i]->get('value') * 0.1);

      // Añado recursos mientras tenga sitio
      if ($free_space > $resource_value){
        $free_space -= $resource_value;
        $new_value = (int)$obj_resources[$i]->get('value') - $resource_value;

        $obj_resources[$i]->set('value', $new_value);
        if (!array_key_exists('resource_'.$resource_id, $explorer_resources_ind)){
          array_push($explorer_resources, ['resource_id'=>$resource_id, 'value'=>$resource_value]);
          $key = end(array_keys($explorer_resources));
          $explorer_resources_ind['resource_'.$resource_id] = $key;
        }
        else{
          $explorer_resources[$explorer_resources_ind['resource_'.$resource_id]] += $resource_value;
        }
      }
    }

    // Guardo el resto de recursos que quedan
    foreach ($obj_resources as $res){
      $res->save();
    }

    $storage_module->set('storage', json_encode($explorer_resources));
    $storage_module->save();
  }

  private function jobDoneJump(){
    // Busco el explorador
    $explorer = new Explorer();
    $explorer->find(['id'=>$this->get('id_explorer')]);

    // Cojo datos del trabajo
    $data = json_decode($this->get('value'),true);
    $explorer->set('last_save_point', $data['id']);
    $explorer->save();
  }

  private $job_name = null;

  public function setJobName($job_name){
    $this->job_name = $job_name;
  }

  public function getJobName(){
    return $this->job_name;
  }
}