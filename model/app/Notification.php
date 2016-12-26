<?php
class Notification extends OBase{
  function __construct(){
    $model_name = 'Notification';
    $tablename  = 'notification';
    $model = array(
        'id'          => array('type'=>Base::PK,       'com'=>'Id única de la notificación'),
        'id_explorer' => array('type'=>Base::NUM,      'com'=>'Id del explorador que recibe la notificación'),
        'type'        => array('type'=>Base::NUM,      'com'=>'Tipo de notificación'),
        'value'       => array('type'=>Base::LONGTEXT, 'com'=>'Contenido de la notificación'),
        'discarded'   => array('type'=>Base::BOOL,     'com'=>'Indica si la notificación ha sido descartada 1 o no 0'),
        'created_at'  => array('type'=>Base::CREATED,  'com'=>'Fecha de creación del registro'),
        'updated_at'  => array('type'=>Base::UPDATED,  'com'=>'Fecha de última modificación del registro')
    );

    parent::load($model_name,$tablename,$model);
  }
}