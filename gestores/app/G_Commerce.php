<?php
class G_Commerce extends G_Base{
  function __construct(){
    $gestor = 'G_Commerce';
    $tablename = 'commerce';
    $model = array(
        'id'          => array('type'=>Base::PK,      'com'=>'Id único del mensaje'),
        'id_first' => array('type'=>Base::NUM,     'com'=>'Id del usuario que envía el mensaje'),
        'first_offers'        => array('type'=>Base::TEXTO,     'len'=>1000, 'com'=>'Id del usuario que recibe el mensaje'),
        'first_asks'       => array('type'=>Base::TEXTO,   'len'=>1000, 'com'=>'Contenido del mensaje'),
        'id_second'   => array('type'=>Base::NUM,    'com'=>'Contenido del mensaje'),
        'second_offers' => array('type'=>Base::TEXTO, 'len'=>1000),
        'created_at'  => array('type'=>Base::CREATED, 'com'=>'Fecha de creación del registro'),
        'updated_at'  => array('type'=>Base::UPDATED, 'com'=>'Fecha de última modificación del registro')
    );

    parent::load($gestor,$tablename,$model);
  }
}