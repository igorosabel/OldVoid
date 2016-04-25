<?php
class G_Facility extends G_Base{
  function __construct(){
    $gestor = 'G_Facility';
    $tablename = 'facility';
    $model = array(
        'id'         => array('type'=>Base::PK,      'com'=>'Id única de la facility'),
        'id_type'    => array('type'=>Base::NUM,     'com'=>'Id del tipo de facility'),
        'id_owner'   => array('type'=>Base::NUM,     'com'=>'Id del usuario dueño del facility'),
        'id_ship'    => array('type'=>Base::NUM,     'com'=>'Id de la nave en la que está equipada o NULL si no está equipada'),
        'size'       => array('type'=>Base::NUM,     'com'=>'Tamaño de la facility 0 small 1 big'),
        'enables'    => array('type'=>Base::TEXTO,   'len'=>100, 'com'=>'Lista de habilidades que tener la facility permite'),
        'crew'       => array('type'=>Base::NUM,     'com'=>'Número de tripulantes que puede alojar o pueden trabajar'),
        'mass'       => array('type'=>Base::NUM,     'com'=>'Peso del facility, para el movimiento'),
        'storage'    => array('type'=>Base::NUM,     'com'=>'Capacidad de almacenamiento del facility'),
        'energy'     => array('type'=>Base::NUM,     'com'=>'Energía necesaria para que el facility funcione'),
        'credits'    => array('type'=>Base::NUM,     'com'=>'Precio de la facility'),
        'created_at' => array('type'=>Base::CREATED, 'com'=>'Fecha de creación del registro'),
        'updated_at' => array('type'=>Base::UPDATED, 'com'=>'Fecha de última modificación del registro')
    );

    parent::load($gestor,$tablename,$model);
  }
}