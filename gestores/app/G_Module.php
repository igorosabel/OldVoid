<?php
class G_Module extends G_Base{
  function __construct(){
    $gestor = 'G_Module';
    $tablename = 'module';
    $model = array(
        'id'         => array('type'=>Base::PK,        'com'=>'Id único del módulo'),
        'id_type'    => array('type'=>Base::NUM,       'com'=>'Id del tipo de módulo'),
        'id_owner'   => array('type'=>Base::NUM,       'com'=>'Id del usuario dueño del módulo'),
        'id_ship'    => array('type'=>Base::NUM,       'com'=>'Id de la nave en la que está equipada o NULL si no está equipada'),
        'size'       => array('type'=>Base::NUM,       'com'=>'Tamaño del módulo 0 small 1 big'),
        'enables'    => array('type'=>Base::TEXTO,     'len'=>100, 'com'=>'Lista de habilidades que tener el módulo permite'),
        'crew'       => array('type'=>Base::NUM,       'com'=>'Número de tripulantes que puede alojar o pueden trabajar'),
        'mass'       => array('type'=>Base::NUM,       'com'=>'Peso del módulo, para el movimiento'),
        'storage_capacity' => array('type'=>Base::NUM, 'com'=>'Capacidad de almacenamiento del módulo'),
        'storage'    => array('type'=>Base::TEXTO,     'len'=>200, 'com'=>'Recursos almacenados'),
        'energy'     => array('type'=>Base::NUM,       'com'=>'Energía necesaria para que el módulo funcione'),
        'credits'    => array('type'=>Base::NUM,       'com'=>'Precio del módulo'),
        'created_at' => array('type'=>Base::CREATED,   'com'=>'Fecha de creación del registro'),
        'updated_at' => array('type'=>Base::UPDATED,   'com'=>'Fecha de última modificación del registro')
    );

    parent::load($gestor,$tablename,$model);
  }
}