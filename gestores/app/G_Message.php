<?php
class G_Message extends G_Base{
  function __construct(){
    $gestor = 'G_Message';
    $tablename = 'message';
    $model = array(
        'id'         => array('type'=>Base::PK,      'com'=>'Id único del mensaje'),
        'from'       => array('type'=>Base::NUM,     'com'=>'Id del usuario que envía el mensaje'),
        'to'         => array('type'=>Base::NUM,     'com'=>'Id del usuario que recibe el mensaje'),
        'content'    => array('type'=>Base::TEXTO,   'len'=>1000, 'com'=>'Contenido del mensaje'),
        'created_at' => array('type'=>Base::CREATED, 'com'=>'Fecha de creación del registro'),
        'updated_at' => array('type'=>Base::UPDATED, 'com'=>'Fecha de última modificación del registro')
    );

    parent::load($gestor,$tablename,$model);
  }
}