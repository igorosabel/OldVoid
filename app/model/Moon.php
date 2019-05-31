<?php
class Moon extends OBase{
  function __construct(){
    $table_name = 'moon';
    $model = [
        'id' => [
          'type'    => Base::PK,
          'comment' => 'Id único de la luna'
        ],
        'id_planet' => [
          'type'    => Base::NUM,
          'comment' => 'Id del planeta al que pertenece'
        ],
        'id_owner' => [
          'type'    => Base::NUM,
          'comment' => 'Id del dueño de la luna'
        ],
        'npc' => [
          'type'    => Base::NUM,
          'comment' => 'Indica si el dueño de la luna es un NPC 1 o no 0'
        ],
        'original_name' => [
          'type'    => Base::TEXT,
          'size'    => 50,
          'comment' => 'Nombre original de la luna'
        ],
        'name' => [
          'type'    => Base::TEXT,
          'size'    => 50,
          'comment' => 'Nombre dado por el descubridor'
        ],
        'radius' => [
          'type'    => Base::NUM,
          'comment' => 'Radio de la luna en kilómetros'
        ],
        'rotation' => [
          'type'    => Base::NUM,
          'comment' => 'Velocidad de rotación de la luna alrededor del planeta'
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
          'comment' => 'Distancia de la luna a su planeta'
        ],
        'explored' => [
          'type'    => Base::BOOL,
          'comment' => 'Indica si la luna ya ha sido explorada por alguien'
        ],
        'explore_time' => [
          'type'    => Base::NUM,
          'comment' => 'Tiempo, en segundos, necesarios para explorar la luna'
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

  private $npc = false;
  private $explored  = false;
  private $resources = [];

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