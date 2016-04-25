<?php
class G_System extends G_Base{
  function __construct(){
    $gestor = 'G_System';
    $tablename = 'system';
    $model = array(
        'id'            => array('type'=>Base::PK,      'com'=>'Id único del sistema solar'),
        'id_discoverer' => array('type'=>Base::NUM,     'com'=>'Id del usuario que ha descubierto el sistema'),
        'original_name' => array('type'=>Base::TEXTO,   'len'=>50, 'com'=>'Nombre original del sistema'),
        'name'          => array('type'=>Base::TEXTO,   'len'=>50, 'com'=>'Nombre del sistema dado por el usuario'),
        'coord_x'       => array('type'=>Base::NUM,     'com'=>'Coordenada X del sistema'),
        'coord_y'       => array('type'=>Base::NUM,     'com'=>'Coordenada Y del sistema'),
        'num_planets'   => array('type'=>Base::NUM,     'com'=>'Número de planetas en el sistema'),
        'sun_id_type'   => array('type'=>Base::NUM,     'com'=>'Tipo de Sol'),
        'width'         => array('type'=>Base::NUM,     'com'=>'Anchura del sistema'),
        'height'        => array('type'=>Base::NUM,     'com'=>'Altura del sistema'),
        'created_at'    => array('type'=>Base::CREATED, 'com'=>'Fecha de creación del registro'),
        'updated_at'    => array('type'=>Base::UPDATED, 'com'=>'Fecha de última modificación del registro')
    );

    parent::load($gestor,$tablename,$model);
  }
}