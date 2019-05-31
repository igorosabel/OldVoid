<?php
class Ship extends OBase{
  function __construct(){
    $table_name = 'ship';
    $model = [
        'id' => [
          'type'    => Base::PK,
          'comment' => 'Id única de la nave'
        ],
        'id_owner' => [
          'type'    => Base::NUM,
          'comment' => 'Id del dueño de la nave'
        ],
        'original_name' => [
          'type'    => Base::TEXT,
          'size'    => 50,
          'comment' => 'Nombre original de la nave'
        ],
        'name' => [
          'type'    => Base::TEXT,
          'size'    => 50,
          'comment' => 'Nombre de la nave'
        ],
        'hull_id_type' => [
          'type'    => Base::NUM,
          'comment' => 'Id del tipo de hull'
        ],
        'hull_strength' => [
          'type'    => Base::NUM,
          'comment' => 'Integridad estructural del hull, aguante ante ataques'
        ],
        'hull_current_strength' => [
          'type'    => Base::NUM,
          'comment' => 'Integridad estructural del hull actual'
        ],
        'hull_mass' => [
          'type'    => Base::NUM,
          'comment' => 'Peso del hull, para el movimiento'
        ],
        'gun_ports' => [
          'type'    => Base::NUM,
          'comment' => 'Número de huecos para introducir armas'
        ],
        'big_module_ports' => [
          'type'    => Base::NUM,
          'comment' => 'Número de los posibles módulos grandes'
        ],
        'small_module_ports' => [
          'type'    => Base::NUM,
          'comment' => 'Número de los posibles módulos pequeños'
        ],
        'shield_id_type' => [
          'type'    => Base::NUM,
          'comment' => 'Id del tipo de shield, para información inicial, nombre...'
        ],
        'shield_strength' => [
          'type'    => Base::NUM,
          'comment' => 'Daño que aguanta el shield'
        ],
        'shield_current_strength' => [
          'type'    => Base::NUM,
          'comment' => 'Daño actual que puede aguantar el shield'
        ],
        'shield_energy' => [
          'type'    => Base::NUM,
          'comment' => 'Energía necesaria para que el shield funcione'
        ],
        'engine_id_type' => [
          'type'    => Base::NUM,
          'comment' => 'Id del tipo de engine, para información inicial, nombre...'
        ],
        'engine_power' => [
          'type'    => Base::NUM,
          'comment' => 'Potencia de empuje del engine'
        ],
        'engine_energy' => [
          'type'    => Base::NUM,
          'comment' => 'Energía necesaria para que el engine funcione'
        ],
        'engine_impulse' => [
          'type'    => Base::NUM,
          'comment' => 'Cantidad de UA por hora que se mueve'
        ],
        'engine_fuel_cost' => [
          'type'    => Base::NUM,
          'comment' => 'Cantidad de fuel que consume por movimiento'
        ],
        'engine_fuel_actual' => [
          'type'    => Base::NUM,
          'comment' => 'Cantidad de fuel que tiene en un momento dado'
        ],
        'generator_id_type' => [
          'type'    => Base::NUM,
          'comment' => 'Id del tipo de generator, para información inicial, nombre...'
        ],
        'generator_power' => [
          'type'    => Base::NUM,
          'comment' => 'Cantidad de energia que genera'
        ],
        'credits' => [
          'type'    => Base::NUM,
          'comment' => 'Precio de la nave'
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

  private $guns          = [];
  private $modules_small = [];
  private $modules_big   = [];

  public function setGuns($g){
    $this->guns = $g;
  }
  public function getGuns(){
    return $this->guns;
  }
  public function addGun($g){
    array_push($this->guns,$g);
  }

  public function setModulesSmall($ms){
    $this->modules_small = $ms;
  }
  public function getModulesSmall(){
    return $this->modules_small;
  }
  public function addModuleSmall($ms){
    array_push($this->modules_small,$ms);
  }

  public function setModulesBig($mb){
    $this->modules_big = $mb;
  }
  public function getModulesBig(){
    return $this->modules_big;
  }
  public function addModuleBig($mb){
    array_push($this->modules_big,$mb);
  }
}