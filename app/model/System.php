<?php
class System extends OBase{
  private $system_service = null;

  function __construct(){
    $this->system_service = new systemService();

    $table_name = 'system';
    $model = [
        'id' => [
          'type'    => Base::PK,
          'comment' => 'Id único del sistema solar'
        ],
        'id_discoverer' => [
          'type'    => Base::NUM,
          'comment' => 'Id del usuario que ha descubierto el sistema'
        ],
        'original_name' => [
          'type'    => Base::TEXT,
          'size'    => 50,
          'comment' => 'Nombre original del sistema'
        ],
        'name' => [
          'type'    => Base::TEXT,
          'size'    => 50,
          'comment' => 'Nombre del sistema dado por el usuario'
        ],
        'num_planets' => [
          'type'    => Base::NUM,
          'comment' => 'Número de planetas en el sistema'
        ],
        'num_npc' => [
          'type'    => Base::NUM,
          'comment' => 'Número de NPC en el sistema'
        ],
        'sun_type' => [
          'type'    => Base::TEXT,
          'size'    => 5,
          'comment' => 'Tipo de Sol'
        ],
        'sun_radius' => [
          'type'    => Base::NUM,
          'comment' => 'Radio del Sol'
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