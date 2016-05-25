<?php
class G_Gun extends G_Base{
  function __construct(){
    $model_name = 'G_Gun';
    $tablename  = 'gun';
    $model = array(
        'id'              => array('type'=>Base::PK,      'com'=>'Id única del gun'),
        'id_type'         => array('type'=>Base::NUM,     'com'=>'Id del tipo de gun'),
        'id_owner'        => array('type'=>Base::NUM,     'com'=>'Id del usuario dueño del gun'),
        'id_ship'         => array('type'=>Base::NUM,     'com'=>'Id de la nave en la que está equipada o NULL si no está equipada'),
        'strength'        => array('type'=>Base::NUM,     'com'=>'Daño que hace'),
        'accuracy'        => array('type'=>Base::NUM,     'com'=>'Indice de acierto del gun'),
        'recharge_time'   => array('type'=>Base::NUM,     'com'=>'Tiempo que tarda en volver a disparar'),
        'ignores_shields' => array('type'=>Base::BOOL,    'com'=>'Indica si el gun esquiva shields 1 o no 0'),
        'energy'          => array('type'=>Base::NUM,     'com'=>'Energía necesaria para que el gun funcione'),
        'credits'         => array('type'=>Base::NUM,     'com'=>'Precio de la gun'),
        'created_at'      => array('type'=>Base::CREATED, 'com'=>'Fecha de creación del registro'),
        'updated_at'      => array('type'=>Base::UPDATED, 'com'=>'Fecha de última modificación del registro')
    );

    parent::load($model_name,$tablename,$model);
  }
}