<?php
class Explorer extends OBase{
  function __construct(){
    $table_name = 'explorer';
    $model = [
        'id' => [
          'type'    => Base::PK,
          'comment' => 'Id único del usuario'
        ],
        'name' => [
          'type'    => Base::TEXT,
          'size'    => 50,
          'comment' => 'Nombre o nick del usuario'
        ],
        'email' => [
          'type'    => Base::TEXT,
          'size'    => 50,
          'comment' => 'Direccion email del usuario'
        ],
        'pass' => [
          'type'    => Base::TEXT,
          'size'    => 50,
          'comment' => 'Contraseña cifrada del usuario'
        ],
        'credits' => [
          'type'    => Base::NUM,
          'comment' => 'Cantidad de créditos del usuario'
        ],
        'current_ship' => [
          'type'    => Base::NUM,
          'comment' => 'Id de la nave que actualmente está usando el explorador'
        ],
        'last_save_point' => [
          'type'    => Base::NUM,
          'comment' => 'Último punto de salvado, Id del sistema'
        ],
        'id_job' => [
          'type'    => Base::NUM,
          'comment' => 'Id del trabajo en curso o NULL si no está haciendo ninguno'
        ],
        'auth' => [
          'type'    => Base::TEXT,
          'size'    => 50,
          'comment' => 'clave auth para la api'
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

  public function login($email,$pass){
    if ($this->find(['email'=>$email])){
      if ($this->get('pass')==$pass){
        return true;
      }
    }
    return false;
  }

  private $ship = null;

  public function setShip($s){
    $this->ship = $s;
  }
  public function getShip(){
    return $this->ship;
  }

  private $system = null;

  public function setSystem($s){
    $this->system = $s;
  }
  public function getSystem(){
    return $this->system;
  }

  public function loadData(){
    $ship = new Ship();
    $ship->find(['id' => $this->get('current_ship')]);
    $this->setShip($ship);

    $system = new System();
    $system->find(['id' => $this->get('last_save_point')]);
    $this->setSystem($system);
  }
}