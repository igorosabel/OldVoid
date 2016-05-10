<?php
class G_Explorer extends G_Base{
  function __construct(){
    $gestor = 'G_Explorer';
    $tablename = 'explorer';
    $model = array(
        'id'         => array('type'=>Base::PK,       'com'=>'Id único del usuario'),
        'name'       => array('type'=>Base::TEXTO,    'len'=>50, 'com'=>'Nombre o nick del usuario'),
        'email'      => array('type'=>Base::TEXTO,    'len'=>50, 'com'=>'Direccion email del usuario'),
        'pass'       => array('type'=>Base::TEXTO,    'len'=>50, 'com'=>'Contraseña cifrada del usuario'),
        'credits'    => array('type'=>Base::NUM,      'com'=>'Cantidad de créditos del usuario'),
        'current_ship'    => array('type'=>Base::NUM, 'com'=>'Id de la nave que actualmente está usando el explorador'),
        'last_save_point' => array('type'=>Base::NUM, 'com'=>'Último punto de salvado, Id del sistema'),
        'id_job'     => array('type'=>Base::NUM,      'com'=>'Id del trabajo en curso o NULL si no está haciendo ninguno'),
        'auth'       => array('type'=>Base::TEXTO,    'len'=>50, 'com'=>'clave auth para la api'),
        'created_at' => array('type'=>Base::CREATED,  'com'=>'Fecha de creación del registro'),
        'updated_at' => array('type'=>Base::UPDATED,  'com'=>'Fecha de última modificación del registro')
    );

    parent::load($gestor,$tablename,$model);
  }
  
  public function login($email,$pass){
    if ($this->buscar(array('email'=>$email))){
      if ($this->get('pass')==$pass){
        return true;
      }
      else{
        return false;
      }
    }
    else{
      return false;
    }
  }

  private $ship   = null;

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
    $ship = new G_Ship();
    $ship->buscar(array('id' => $this->get('current_ship')));
    $this->setShip($ship);

    $system = new G_System();
    $system->buscar(array('id' => $this->get('last_save_point')));
    $this->setSystem($system);
  }
}