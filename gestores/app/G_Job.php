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
  }

  public function jobDoneExplore(){
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
}