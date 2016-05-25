<?php
class G_Moon extends G_Base{
  function __construct(){
    $model_name = 'G_Moon';
    $tablename  = 'moon';
    $model = array(
        'id'            => array('type'=>Base::PK,      'com'=>'Id único de la luna'),
        'id_planet'     => array('type'=>Base::NUM,     'com'=>'Id del planeta al que pertenece'),
        'id_owner'      => array('type'=>Base::NUM,     'com'=>'Id del dueño de la luna'),
        'npc'           => array('type'=>Base::NUM,     'com'=>'Indica si el dueño de la luna es un NPC 1 o no 0'),
        'original_name' => array('type'=>Base::TEXTO,   'len'=>50, 'com'=>'Nombre original de la luna'),
        'name'          => array('type'=>Base::TEXTO,   'len'=>50, 'com'=>'Nombre dado por el descubridor'),
        'radius'        => array('type'=>Base::NUM,     'com'=>'Radio de la luna en kilómetros'),
        'rotation'      => array('type'=>Base::NUM,     'com'=>'Velocidad de rotación de la luna alrededor del planeta'),
        'survival'      => array('type'=>Base::NUM,     'com'=>'Indice de supervivencia'),
        'has_life'      => array('type'=>Base::BOOL,    'com'=>'Indica si tiene vida 1 o no 0'),
        'distance'      => array('type'=>Base::NUM,     'com'=>'Distancia de la luna a su planeta'),
        'explored'      => array('type'=>Base::BOOL,    'com'=>'Indica si la luna ya ha sido explorada por alguien'),
        'explore_time'  => array('type'=>Base::NUM,     'com'=>'Tiempo, en segundos, necesarios para explorar la luna'),
        'created_at'    => array('type'=>Base::CREATED, 'com'=>'Fecha de creación del registro'),
        'updated_at'    => array('type'=>Base::UPDATED, 'com'=>'Fecha de última modificación del registro')
    );

    parent::load($model_name,$tablename,$model);
  }
  
  private $npc = false;
  private $explored  = false;
  private $resources = array();
  
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