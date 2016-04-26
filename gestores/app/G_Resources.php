<?php
class G_Resources extends G_Base{
  function __construct(){
    $gestor = 'G_Resources';
    $tablename = 'resources';
    $model = array(
      'id_planet'        => array('type'=>Base::PK,      'com'=>'Id del planeta donde está el recurso o NULL si es una luna',  'incr'=>false),
      'id_moon'          => array('type'=>Base::PK,      'com'=>'Id de la luna donde está el recurso o NULL si es un planeta', 'incr'=>false),
      'id_resource_type' => array('type'=>Base::PK,      'com'=>'Id del tipo de recurso', 'incr'=>false),
      'value'            => array('type'=>Base::NUM,     'com'=>'Armas que tiene a la venta por defecto'),
      'created_at'       => array('type'=>Base::CREATED, 'com'=>'Fecha de creación del registro'),
      'updated_at'       => array('type'=>Base::UPDATED, 'com'=>'Fecha de última modificación del registro')
    );

    parent::load($gestor,$tablename,$model,array('id_planet','id_moon','id_resource_type'));
  }
}