<?php
class G_Ship extends G_Base{
  function __construct(){
    $gestor = 'G_Ship';
    $tablename = 'ship';
    $model = array(
        'id'                 => array('type'=>Base::PK,       'com'=>'Id única de la nave'),
        'id_owner'           => array('type'=>Base::NUM,      'com'=>'Id del dueño de la nave'),
        'original_name'      => array('type'=>Base::TEXTO,    'len'=>50, 'com'=>'Nombre original de la nave'),
        'name'               => array('type'=>Base::TEXTO,    'len'=>50, 'com'=>'Nombre de la nave'),
        'hull_id_type'       => array('type'=>Base::NUM,      'com'=>'Id del tipo de hull'),
        'hull_strength'      => array('type'=>Base::NUM,      'com'=>'Integridad estructural del hull, aguante ante ataques'),
        'hull_current_strength' => array('type'=>Base::NUM,   'com'=>'Integridad estructural del hull actual'),
        'hull_mass'          => array('type'=>Base::NUM,      'com'=>'Peso del hull, para el movimiento'),
        'gun_ports'          => array('type'=>Base::BOOL,     'com'=>'Número de huecos para introducir armas'),
        'big_module_ports'   => array('type'=>Base::NUM,      'com'=>'Número de los posibles módulos grandes'),
        'small_module_ports' => array('type'=>Base::NUM,      'com'=>'Número de los posibles módulos pequeños'),
        'shield_id_type'     => array('type'=>Base::NUM,      'com'=>'Id del tipo de shield, para información inicial, nombre...'),
        'shield_strength'    => array('type'=>Base::NUM,      'com'=>'Daño que aguanta el shield'),
        'shield_current_strength' => array('type'=>Base::NUM, 'com'=>'Daño actual que puede aguantar el shield'),
        'shield_energy'      => array('type'=>Base::NUM,      'com'=>'Energía necesaria para que el shield funcione'),
        'engine_id_type'     => array('type'=>Base::NUM,      'com'=>'Id del tipo de engine, para información inicial, nombre...'),
        'engine_power'       => array('type'=>Base::NUM,      'com'=>'Potencia de empuje del engine'),
        'engine_energy'      => array('type'=>Base::NUM,      'com'=>'Energía necesaria para que el engine funcione'),
        'engine_impulse'     => array('type'=>Base::NUM,      'com'=>'Cantidad de UA por hora que se mueve'),
        'engine_fuel_cost'   => array('type'=>Base::NUM,      'com'=>'Cantidad de fuel que consume por movimiento'),
        'engine_fuel_actual' => array('type'=>Base::NUM,      'com'=>'Cantidad de fuel que tiene en un momento dado'),
        'generator_id_type'  => array('type'=>Base::NUM,      'com'=>'Id del tipo de generator, para información inicial, nombre...'),
        'generator_power'    => array('type'=>Base::NUM,      'com'=>'Cantidad de energia que genera'),
        'credits'            => array('type'=>Base::NUM,      'com'=>'Precio de la nave'),
        'created_at'         => array('type'=>Base::CREATED,  'com'=>'Fecha de creación del registro'),
        'updated_at'         => array('type'=>Base::UPDATED,  'com'=>'Fecha de última modificación del registro')
    );

    parent::load($gestor,$tablename,$model);
  }

  private $guns    = array();
  private $modules = array();

  public function setGuns($g){
    $this->guns = $g;
  }

  public function getGuns(){
    return $this->guns;
  }

  public function addGun($g){
    array_push($this->guns,$g);
  }

  public function setModules($m){
    $this->modules = $m;
  }

  public function getModules(){
    return $this->modules;
  }

  public function addModule($m){
    array_push($this->modules,$m);
  }
}