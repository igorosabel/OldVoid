<?php
class G_SystemDistance extends G_Base{
  function __construct(){
    $gestor = 'G_SystemDistance';
    $tablename = 'system_distance';
    $model = array(
        'id_system_1' => array('type'=>Base::PK,      'com'=>'Id del primer sistema',  'incr'=>false),
        'id_system_2' => array('type'=>Base::PK,      'com'=>'Id del segundo sistema', 'incr'=>false),
        'distance'    => array('type'=>Base::NUM,     'com'=>'Grados de separación entre los dos sistemas'),
        'created_at'  => array('type'=>Base::CREATED, 'com'=>'Fecha de creación del registro'),
        'updated_at'  => array('type'=>Base::UPDATED, 'com'=>'Fecha de última modificación del registro')
    );

    parent::load($gestor,$tablename,$model,array('id_system_1','id_system_2'));
  }

  private $known = false;

  public function setKnown($k){
    $this->known = $k;
  }

  public function getKnown(){
    return $this->known;
  }
}