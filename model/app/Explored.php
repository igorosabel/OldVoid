<?php
class Explored extends OBase{
  function __construct(){
    $model_name = 'Explored';
    $tablename  = 'explored';
    $model = array(
      'id_explorer' => array('type'=>Base::PK,      'com'=>'Id del explorador',                               'incr'=>false),
      'id_planet'   => array('type'=>Base::PK,      'com'=>'Id del planeta explorado o null si es una luna',  'incr'=>false),
      'id_moon'     => array('type'=>Base::PK,      'com'=>'Id de la luna explorada o null si es un planeta', 'incr'=>false),
      'created_at'  => array('type'=>Base::CREATED, 'com'=>'Fecha de creación del registro'),
      'updated_at'  => array('type'=>Base::UPDATED, 'com'=>'Fecha de última modificación del registro')
    );

    parent::load($model_name,$tablename,$model,array('id_explorer','id_planet','id_moon'));
  }
}