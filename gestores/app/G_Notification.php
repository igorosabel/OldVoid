<?php
class G_Notification extends G_Base{
  function __construct(){
    $gestor = 'G_Notification';
    $tablename = 'notification';
    $model = array(
        'id'          => array('type'=>Base::PK,      'com'=>'Id único del mensaje'),
        'id_explorer' => array('type'=>Base::NUM,     'com'=>'Id del usuario que envía el mensaje'),
        'type'        => array('type'=>Base::NUM,     'com'=>'Id del usuario que recibe el mensaje'),
        'value'       => array('type'=>Base::TEXTO,   'len'=>1000, 'com'=>'Contenido del mensaje'),
        'discarded'   => array('type'=>Base::BOOL,    'com'=>'Contenido del mensaje'),
        'created_at'  => array('type'=>Base::CREATED, 'com'=>'Fecha de creación del registro'),
        'updated_at'  => array('type'=>Base::UPDATED, 'com'=>'Fecha de última modificación del registro')
    );

    parent::load($gestor,$tablename,$model);
  }
}