<?php
class G_Crew extends G_Base{
  function __construct(){
    $model_name = 'G_Crew';
    $tablename  = 'crew';
    $model = array(
        'id'         => array('type'=>Base::PK,      'com'=>'Id único del tripulante'),
        'name'       => array('type'=>Base::TEXTO,   'len'=>50, 'com'=>'Nombre del tripulante'),
        'race'       => array('type'=>Base::NUM,     'com'=>'Id de la raza del tripulante'),
        'created_at' => array('type'=>Base::CREATED, 'com'=>'Fecha de creación del registro'),
        'updated_at' => array('type'=>Base::UPDATED, 'com'=>'Fecha de última modificación del registro')
    );

    parent::load($model_name,$tablename,$model);
  }
}