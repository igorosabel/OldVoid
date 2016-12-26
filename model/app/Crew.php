<?php
class Crew extends OBase{
  function __construct(){
    $model_name = 'Crew';
    $tablename  = 'crew';
    $model = array(
        'id'         => array('type'=>Base::PK,                 'com'=>'Id único del tripulante'),
        'name'       => array('type'=>Base::TEXT,    'len'=>50, 'com'=>'Nombre del tripulante'),
        'race'       => array('type'=>Base::NUM,                'com'=>'Id de la raza del tripulante'),
        'created_at' => array('type'=>Base::CREATED,            'com'=>'Fecha de creación del registro'),
        'updated_at' => array('type'=>Base::UPDATED,            'com'=>'Fecha de última modificación del registro')
    );

    parent::load($model_name,$tablename,$model);
  }
}