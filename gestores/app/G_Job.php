<?php
class G_Job extends G_Base{
  function __construct(){
    $gestor = 'G_Job';
    $tablename = 'job';
    $model = array(
        'id'          => array('type'=>Base::PK,       'com'=>'Id único del trabajo'),
        'id_explorer' => array('type'=>Base::NUM,      'com'=>'Id del explorador que hace el trabajo'),
        'type'        => array('type'=>Base::NUM,      'com'=>'Tipo de trabajo'),
        'value'       => array('type'=>Base::TEXTO,    'len'=>300, 'com'=>'Información extra del trabajo'),
        'start'       => array('type'=>Base::NUM,      'com'=>'Timestamp de la fecha de inicio'),
        'duration'    => array('type'=>Base::NUM,      'com'=>'Duración del trabajo'),
        'created_at'  => array('type'=>Base::CREATED,  'com'=>'Fecha de creación del registro'),
        'updated_at'  => array('type'=>Base::UPDATED,  'com'=>'Fecha de última modificación del registro')
    );

    parent::load($gestor,$tablename,$model);
  }
  
  private $status = '';
  
  public function setStatus($s){
    $this->status = $s;
  }
  public function getStatus(){
    return $this->status;
  }

  public function jobDone(){
    if ($this->get('type')==Job::EXPLORE){
      $this->jobDoneExplore();
    }
    if ($this->get('type')==Job::RESOURCES){
      $this->jobDoneResources();
    }
    if ($this->get('type')==Job::JUMP){
      $this->jobDoneJump();
    }
  }

  private function jobDoneExplore(){
    $data = json_decode($this->get('value'),true);
    $explored = new G_Explored();
    $explored->set('id_explorer',$this->get('id_explorer'));
    if ($data['type']=='planet') {
      $explored->set('id_moon', 0);
      $explored->set('id_planet', $data['id']);

      $pl = new G_Planet();
      $pl->buscar(array('id'=>$data['id']));
      if (!$pl->get('explored')){
        $pl->setExplored(true);
        $pl->salvar();
        System::generateResources('planet',$pl);
      }
    }
    if ($data['type']=='moon') {
      $explored->set('id_moon', $data['id']);
      $explored->set('id_planet', 0);

      $mo = new G_Moon();
      $mo->buscar(array('id'=>$data['id']));
      if (!$mo->get('explored')){
        $mo->setExplored(true);
        $mo->salvar();
        System::generateResources('moon',$mo);
      }
    }

    $explored->salvar();
  }
  
  private function jobDoneResources(){
    // Busco el explorador
    $explorer = new G_Explorer();
    $explorer->buscar(array('id'=>$this->get('id_explorer')));
    
    // Busco la nave del explorador
    $ship = new G_Ship();
    $ship->buscar(array('id'=>$explorer->get('current_ship')));

    // Cargo sus módulos
    $modules = Ship::loadModules($ship);
    $storage_module = null;

    // Busco el módulo de almacenamiento
    foreach ($modules as $module){
      if ($module->get('enables')==Ship::MODULE_STORAGE){
        $storage_module = $module;
      }
    }

    $free_space = $storage_module->get('storage_capacity');
    $explorer_resources = array();

    // Calculo espacio libre en el módulo
    if (!is_null($storage_module->get('storage'))){
      $module_data = json_decode($storage_module->get('storage'),true);
      foreach ($module_data as $key=>$value){
        // Espacio total menos lo que ya lleva
        $free_space -= $value;
        $explorer_resources[$key] = $value;
      }
    }

    // Cojo datos del trabajo
    $data = json_decode($this->get('value'),true);
    
    // Cojo el planeta o la luna
    if ($data['type']=='planet'){
      $obj = new G_Planet();
      $obj->buscar(array('id'=>$data['id']));
    }
    if ($data['type']=='moon'){
      $obj = new G_Moon();
      $obj->buscar(array('id'=>$data['id']));
    }

    // Cargo recursos del planeta o luna
    $obj->setResources(System::loadResources($obj,$data['type']));
    
    $obj_resources = $obj->getResources();
    $total_resources = 0;

    // El jugador obtiene un 10% de cada recurso que hay en el planeta
    for ($i=0;$i<count($obj_resources);$i++){
      $resource_id    = $obj_resources[$i]->get('id_resource_type');
      $resource_value = floor((int)$obj_resources[$i]->get('value') * 0.1);

      // Añado recursos mientras tenga sitio
      if ($free_space>$resource_value){
        $free_space -= $resource_value;
        $new_value = (int)$obj_resources[$i]->get('value') - $resource_value;

        $obj_resources[$i]->set('value', $new_value);
        if (!array_key_exists('resource_'.$resource_id, $explorer_resources)){
          $explorer_resources['resource_'.$resource_id] = $resource_value;
        }
        else{
          $explorer_resources['resource_'.$resource_id] += $resource_value;
        }
      }
    }

    // Guardo el resto de recursos que quedan
    foreach ($obj_resources as $res){
      $res->salvar();
    }
    
    $storage_module->set('storage',json_encode($explorer_resources));
    $storage_module->salvar();
  }

  private function jobDoneJump(){
    // Busco el explorador
    $explorer = new G_Explorer();
    $explorer->buscar(array('id'=>$this->get('id_explorer')));

    // Cojo datos del trabajo
    $data = json_decode($this->get('value'),true);
    $explorer->set('last_save_point',$data['id']);
    $explorer->salvar();
  }
}