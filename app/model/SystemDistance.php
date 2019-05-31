<?php
class SystemDistance extends OBase{
  function __construct(){
    $table_name = 'system_distance';
    $model = [
        'id_system_1' => [
          'type'    => Base::PK,
          'comment' => 'Id del primer sistema',
          'incr'    => false
        ],
        'id_system_2' => [
          'type'    => Base::PK,
          'comment' => 'Id del segundo sistema',
          'incr'    => false
        ],
        'distance' => [
          'type'    => Base::NUM,
          'comment' => 'Grados de separación entre los dos sistemas'
        ],
        'created_at' => [
          'type'    => Base::CREATED,
          'comment' => 'Fecha de creación del registro'
        ],
        'updated_at' => [
          'type'    => Base::UPDATED,
          'comment' => 'Fecha de última modificación del registro'
        ]
    ];

    parent::load($table_name, $model);
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
    $sys = new System();
    $sys->find(['id'=>$this->get('id_system_1')]);
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
    $sys = new System();
    $sys->find(['id'=>$this->get('id_system_2')]);
    $this->setSystem2($sys);
  }
  public function setSystem2($s2){
    $this->system_2 = $s2;
  }
  public function getSystem2(){
    return $this->system_2;
  }
}