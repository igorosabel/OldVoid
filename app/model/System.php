<?php
class System extends OModel{
  private $system_service = null;

  function __construct(){
    $this->system_service = new systemService();

    $table_name = 'system';
    $model = [
        'id' => [
          'type'    => OCore::PK,
          'comment' => 'Id único del sistema solar'
        ],
        'id_discoverer' => [
          'type'    => OCore::NUM,
          'comment' => 'Id del usuario que ha descubierto el sistema'
        ],
        'original_name' => [
          'type'    => OCore::TEXT,
          'size'    => 50,
          'comment' => 'Nombre original del sistema'
        ],
        'name' => [
          'type'    => OCore::TEXT,
          'size'    => 50,
          'comment' => 'Nombre del sistema dado por el usuario'
        ],
        'num_planets' => [
          'type'    => OCore::NUM,
          'comment' => 'Número de planetas en el sistema'
        ],
        'num_npc' => [
          'type'    => OCore::NUM,
          'comment' => 'Número de NPC en el sistema'
        ],
        'sun_type' => [
          'type'    => OCore::TEXT,
          'size'    => 5,
          'comment' => 'Tipo de Sol'
        ],
        'sun_radius' => [
          'type'    => OCore::NUM,
          'comment' => 'Radio del Sol'
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

  private $num_explorers = 0;

  public function setNumExplorers($n){
    $this->num_explorers = $n;
  }
  public function getNumExplorers(){
    return $this->num_explorers;
  }

  public function loadNumExplorers($ex=null){
    $this->setNumExplorers( $this->system_service->getExplorersInSystem($ex, $this->get('id')) );
  }
}