<?php
class G_SystemDistance extends G_Base{
  function __construct(){
    $model_name = 'G_SystemDistance';
    $tablename  = 'system_distance';
    $model = array(
        'id_system_1' => array('type'=>Base::PK,      'com'=>'Id del primer sistema',  'incr'=>false),
        'id_system_2' => array('type'=>Base::PK,      'com'=>'Id del segundo sistema', 'incr'=>false),
        'distance'    => array('type'=>Base::NUM,     'com'=>'Grados de separación entre los dos sistemas'),
        'created_at'  => array('type'=>Base::CREATED, 'com'=>'Fecha de creación del registro'),
        'updated_at'  => array('type'=>Base::UPDATED, 'com'=>'Fecha de última modificación del registro')
    );

    parent::load($model_name,$tablename,$model,array('id_system_1','id_system_2'));
  }

  private $known = false;

  public function setKnown($k){
    $this->known = $k;
  }
  public function getKnown(){
    return $this->known;
  }
  
  private $system_1 = null;
  
  public function loadSystem1(){
    $sys = new G_System();
    $sys->find(array('id'=>$this->get('id_system_1')));
    $this->setSystem1($sys);
  }
  public function setSystem1($s1){
    $this->system_1 = $s1;
  }
  public function getSystem1(){
    return $this->system_1;
  }
  
  private $system_2 = null;
  
  public function loadSystem2(){
    $sys = new G_System();
    $sys->find(array('id'=>$this->get('id_system_2')));
    $this->setSystem2($sys);
  }
  public function setSystem2($s2){
    $this->system_2 = $s2;
  }
  public function getSystem2(){
    return $this->system_2;
  }
}