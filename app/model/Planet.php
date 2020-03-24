<?php
class Planet extends OModel{
  function __construct(){
    $table_name = 'planet';
    $model = [
        'id' => [
          'type'    => OCore::PK,
          'comment' => 'Id único del sistema solar'
        ],
        'id_system' => [
          'type'    => OCore::NUM,
          'comment' => 'Id del sistema al que pertenece el planeta'
        ],
        'id_owner' => [
          'type'    => OCore::NUM,
          'comment' => 'Id del dueño del planeta'
        ],
        'npc' => [
          'type'    => OCore::BOOL,
          'comment' => 'Indica si el dueño del planeta es un NPC 1 o no 0'
        ],
        'original_name' => [
          'type'    => OCore::TEXT,
          'size'    => 50,
          'comment' => 'Nombre original del planeta'
        ],
        'name' => [
          'type'    => OCore::TEXT,
          'size'    => 50,
          'comment' => 'Nombre dado por el descubridor'
        ],
        'id_type' => [
          'type'    => OCore::NUM,
          'comment' => 'Id del tipo de planeta'
        ],
        'radius' => [
          'type'    => OCore::NUM,
          'comment' => 'Radio del planeta en kilómetros'
        ],
        'rotation' => [
          'type'    => OCore::NUM,
          'comment' => 'Velocidad de rotación del planeta alrededor de la estrella'
        ],
        'survival' => [
          'type'    => OCore::NUM,
          'comment' => 'Indice de supervivencia'
        ],
        'has_life' => [
          'type'    => OCore::BOOL,
          'comment' => 'Indica si tiene vida 1 o no 0'
        ],
        'distance' => [
          'type'    => OCore::NUM,
          'comment' => 'Distancia del planeta a su sol'
        ],
        'num_moons' => [
          'type'    => OCore::NUM,
          'comment' => 'Número de lunas en el planeta'
        ],
        'explored' => [
          'type'    => OCore::BOOL,
          'comment' => 'Indica si el planeta ya ha sido explorado por alguien'
        ],
        'explore_time' => [
          'type'    => OCore::NUM,
          'comment' => 'Tiempo, en segundos, necesarios para explorar el planeta'
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