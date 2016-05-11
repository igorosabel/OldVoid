<?php
class G_Planet extends G_Base{
  function __construct(){
    $gestor = 'G_Planet';
    $tablename = 'planet';
    $model = array(
        'id'            => array('type'=>Base::PK,      'com'=>'Id único del sistema solar'),
        'id_system'     => array('type'=>Base::NUM,     'com'=>'Id del sistema al que pertenece el planeta'),
        'id_owner'      => array('type'=>Base::NUM,     'com'=>'Id del dueño del planeta'),
        'npc'           => array('type'=>Base::BOOL,    'com'=>'Indica si el dueño del planeta es un NPC 1 o no 0'),
        'original_name' => array('type'=>Base::TEXTO,   'len'=>50, 'com'=>'Nombre original del planeta'),
        'name'          => array('type'=>Base::TEXTO,   'len'=>50, 'com'=>'Nombre dado por el descubridor'),
        'id_type'       => array('type'=>Base::NUM,     'com'=>'Id del tipo de planeta'),
        'radius'        => array('type'=>Base::NUM,     'com'=>'Radio del planeta en kilómetros'),
        'survival'      => array('type'=>Base::NUM,     'com'=>'Indice de supervivencia'),
        'has_life'      => array('type'=>Base::BOOL,    'com'=>'Indica si tiene vida 1 o no 0'),
        'distance'      => array('type'=>Base::NUM,     'com'=>'Distancia del planeta a su sol'),
        'num_moons'     => array('type'=>Base::NUM,     'com'=>'Número de lunas en el planeta'),
        'explored'      => array('type'=>Base::BOOL,    'com'=>'Indica si el planeta ya ha sido explorado por alguien'),
        'created_at'    => array('type'=>Base::CREATED, 'com'=>'Fecha de creación del registro'),
        'updated_at'    => array('type'=>Base::UPDATED, 'com'=>'Fecha de última modificación del registro')
    );

    parent::load($gestor,$tablename,$model);
  }
  
  private $moons     = array();
  private $npc       = null;
  private $explored  = false;
  private $resources = array();
  
  public function setMoons($m){
    $this->moons = $m;
  }
  public function getMoons(){
    return $this->moons;
  }
  
  public function setNPC($n){
    $this->npc = $n;
  }
  public function getNPC(){
    return $this->npc;
  }

  public function setExplored($e){
    $this->explored = $e;
  }
  public function getExplored(){
    return $this->explored;
  }

  public function setResources($r){
    $this->resources = $r;
  }
  public function getResources(){
    return $this->resources;
  }
}