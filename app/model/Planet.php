<?php
class Planet extends OBase{
  function __construct(){
    $table_name = 'planet';
    $model = [
        'id' => [
          'type'    => Base::PK,
          'comment' => 'Id único del sistema solar'
        ],
        'id_system' => [
          'type'    => Base::NUM,
          'comment' => 'Id del sistema al que pertenece el planeta'
        ],
        'id_owner' => [
          'type'    => Base::NUM,
          'comment' => 'Id del dueño del planeta'
        ],
        'npc' => [
          'type'    => Base::BOOL,
          'comment' => 'Indica si el dueño del planeta es un NPC 1 o no 0'
        ],
        'original_name' => [
          'type'    => Base::TEXT,
          'size'    => 50,
          'comment' => 'Nombre original del planeta'
        ],
        'name' => [
          'type'    => Base::TEXT,
          'size'    => 50,
          'comment' => 'Nombre dado por el descubridor'
        ],
        'id_type' => [
          'type'    => Base::NUM,
          'comment' => 'Id del tipo de planeta'
        ],
        'radius' => [
          'type'    => Base::NUM,
          'comment' => 'Radio del planeta en kilómetros'
        ],
        'rotation' => [
          'type'    => Base::NUM,
          'comment' => 'Velocidad de rotación del planeta alrededor de la estrella'
        ],
        'survival' => [
          'type'    => Base::NUM,
          'comment' => 'Indice de supervivencia'
        ],
        'has_life' => [
          'type'    => Base::BOOL,
          'comment' => 'Indica si tiene vida 1 o no 0'
        ],
        'distance' => [
          'type'    => Base::NUM,
          'comment' => 'Distancia del planeta a su sol'
        ],
        'num_moons' => [
          'type'    => Base::NUM,
          'comment' => 'Número de lunas en el planeta'
        ],
        'explored' => [
          'type'    => Base::BOOL,
          'comment' => 'Indica si el planeta ya ha sido explorado por alguien'
        ],
        'explore_time' => [
          'type'    => Base::NUM,
          'comment' => 'Tiempo, en segundos, necesarios para explorar el planeta'
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

  private $moons     = [];
  private $npc       = null;
  private $explored  = false;
  private $resources = [];

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