<?php
class ShipCrew extends OBase{
  function __construct(){
    $model_name = 'ShipCrew';
    $tablename  = 'ship_crew';
    $model = array(
      'id_ship'    => array('type'=>Base::PK,      'com'=>'Id de la nave donde va el tripulante',  'incr'=>false),
      'id_crew'    => array('type'=>Base::PK,      'com'=>'Id del tripulante',                     'incr'=>false),
      'created_at' => array('type'=>Base::CREATED, 'com'=>'Fecha de creación del registro'),
      'updated_at' => array('type'=>Base::UPDATED, 'com'=>'Fecha de última modificación del registro')
    );

    parent::load($model_name,$tablename,$model,array('id_ship','id_crew'));
  }
}