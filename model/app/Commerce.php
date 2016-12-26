<?php
class Commerce extends OBase{
  function __construct(){
    $model_name = 'Commerce';
    $tablename  = 'commerce';
    $model = array(
        'id'            => array('type'=>Base::PK,       'com'=>'Id única de la transacción'),
        'id_first'      => array('type'=>Base::NUM,      'com'=>'Id del explorador que inicia la transacción'),
        'first_offers'  => array('type'=>Base::LONGTEXT, 'com'=>'Lo que ofrece el primer jugador, json'),
        'first_asks'    => array('type'=>Base::LONGTEXT, 'com'=>'Lo que pide el primer explorador'),
        'id_second'     => array('type'=>Base::NUM,      'com'=>'Id del segundo explorador'),
        'second_offers' => array('type'=>Base::LONGTEXT, 'com'=>'Lo que ofrece el segundo jugador'),
        'second_asks'   => array('type'=>Base::LONGTEXT, 'com'=>'Lo que pide el segundo explorador'),
        'status'        => array('type'=>Base::NUM,      'com'=>'Estado de la transacción, esperando a usuario 1-2, terminada 3, cancelada 4'),
        'created_at'    => array('type'=>Base::CREATED,  'com'=>'Fecha de creación del registro'),
        'updated_at'    => array('type'=>Base::UPDATED,  'com'=>'Fecha de última modificación del registro')
    );

    parent::load($model_name,$tablename,$model);
  }
}