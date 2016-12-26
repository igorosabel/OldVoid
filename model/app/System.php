<?php
class System extends OBase{
  function __construct(){
    $model_name = 'System';
    $tablename  = 'system';
    $model = array(
        'id'            => array('type'=>Base::PK,                 'com'=>'Id único del sistema solar'),
        'id_discoverer' => array('type'=>Base::NUM,                'com'=>'Id del usuario que ha descubierto el sistema'),
        'original_name' => array('type'=>Base::TEXT,    'len'=>50, 'com'=>'Nombre original del sistema'),
        'name'          => array('type'=>Base::TEXT,    'len'=>50, 'com'=>'Nombre del sistema dado por el usuario'),
        'num_planets'   => array('type'=>Base::NUM,                'com'=>'Número de planetas en el sistema'),
        'num_npc'       => array('type'=>Base::NUM,                'com'=>'Número de NPC en el sistema'),
        'sun_type'      => array('type'=>Base::TEXT,    'len'=>5,  'com'=>'Tipo de Sol'),
        'sun_radius'    => array('type'=>Base::NUM,                'com'=>'Radio del Sol'),
        'created_at'    => array('type'=>Base::CREATED,            'com'=>'Fecha de creación del registro'),
        'updated_at'    => array('type'=>Base::UPDATED,            'com'=>'Fecha de última modificación del registro')
    );

    parent::load($model_name,$tablename,$model);
  }

  private $num_explorers = 0;

  public function setNumExplorers($n){
    $this->num_explorers = $n;
  }
  public function getNumExplorers(){
    return $this->num_explorers;
  }

  public function loadNumExplorers($ex=null){
    $this->setNumExplorers( stSystem::getExplorersInSystem($ex,$this->get('id')) );
  }
}