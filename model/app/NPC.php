<?php
class NPC extends OBase{
  function __construct(){
    $model_name = 'NPC';
    $tablename  = 'npc';
    $model = array(
        'id'                => array('type'=>Base::PK,                  'com'=>'Id único del NPC'),
        'name'              => array('type'=>Base::TEXT,    'len'=>50,  'com'=>'Nombre del NPC'),
        'id_race'           => array('type'=>Base::NUM,                 'com'=>'Id del tipo de raza del NPC'),
        'hulls_start'       => array('type'=>Base::TEXT,    'len'=>200, 'com'=>'Hulls que tiene a la venta por defecto'),
        'hulls_actual'      => array('type'=>Base::TEXT,    'len'=>200, 'com'=>'Hulls que tiene actualmente a la venta'),
        'shields_start'     => array('type'=>Base::TEXT,    'len'=>200, 'com'=>'Shields que tiene a la venta por defecto'),
        'shields_actual'    => array('type'=>Base::TEXT,    'len'=>200, 'com'=>'Shields que tiene actualmente a la venta'),
        'engines_start'     => array('type'=>Base::TEXT,    'len'=>200, 'com'=>'Engines que tiene a la venta por defecto'),
        'engines_actual'    => array('type'=>Base::TEXT,    'len'=>200, 'com'=>'Engines que tiene actualmente a la venta'),
        'generators_start'  => array('type'=>Base::TEXT,    'len'=>200, 'com'=>'Generators que tiene a la venta por defecto'),
        'generators_actual' => array('type'=>Base::TEXT,    'len'=>200, 'com'=>'Generators que tiene actualmente a la venta'),
        'guns_start'        => array('type'=>Base::TEXT,    'len'=>200, 'com'=>'Armas que tiene a la venta por defecto'),
        'guns_actual'       => array('type'=>Base::TEXT,    'len'=>200, 'com'=>'Armas que tiene actualmente a la venta'),
        'modules_start'     => array('type'=>Base::TEXT,    'len'=>200, 'com'=>'Módulos que tiene a la venta por defecto'),
        'modules_actual'    => array('type'=>Base::TEXT,    'len'=>200, 'com'=>'Módulos que tiene actualmente a la venta'),
        'resources_start'   => array('type'=>Base::TEXT,    'len'=>200, 'com'=>'Recursos que tiene a la venta por defecto'),
        'resources_actual'  => array('type'=>Base::TEXT,    'len'=>200, 'com'=>'Recursos que tiene actualmente a la venta'),
        'last_reset'        => array('type'=>Base::DATE,                'com'=>'Fecha y hora de la última vez que se ha reseteado'),
        'created_at'        => array('type'=>Base::CREATED,             'com'=>'Fecha de creación del registro'),
        'updated_at'        => array('type'=>Base::UPDATED,             'com'=>'Fecha de última modificación del registro')
    );

    parent::load($model_name,$tablename,$model);
  }
}