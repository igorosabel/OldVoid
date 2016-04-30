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
        'last_save_point' => array('type'=>Base::NUM, 'com'=>'Último punto de salvado, Id del sistema'),
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
}