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
}