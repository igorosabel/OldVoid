<?php
class Message extends OBase{
  function __construct(){
    $model_name = 'Message';
    $tablename  = 'message';
    $model = array(
        'id'         => array('type'=>Base::PK,       'com'=>'Id único del mensaje'),
        'from'       => array('type'=>Base::NUM,      'com'=>'Id del usuario que envía el mensaje'),
        'to'         => array('type'=>Base::NUM,      'com'=>'Id del usuario que recibe el mensaje'),
        'content'    => array('type'=>Base::LONGTEXT, 'com'=>'Contenido del mensaje'),
        'created_at' => array('type'=>Base::CREATED,  'com'=>'Fecha de creación del registro'),
        'updated_at' => array('type'=>Base::UPDATED,  'com'=>'Fecha de última modificación del registro')
    );

    parent::load($model_name,$tablename,$model);
  }
}