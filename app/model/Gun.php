<?php
class Gun extends OBase{
  function __construct(){
    $table_name = 'gun';
    $model = [
        'id' => [
          'type'    => Base::PK,
          'comment' => 'Id única del gun'
        ],
        'id_type' => [
          'type'    => Base::NUM,
          'comment' => 'Id del tipo de gun'
        ],
        'id_owner' => [
          'type'    => Base::NUM,
          'comment' => 'Id del usuario dueño del gun'
        ],
        'id_ship' => [
          'type'    => Base::NUM,
          'comment' => 'Id de la nave en la que está equipada o NULL si no está equipada'
        ],
        'strength' => [
          'type'    => Base::NUM,
          'comment' => 'Daño que hace'
        ],
        'accuracy' => [
          'type'    => Base::NUM,
          'comment' => 'Indice de acierto del gun'
        ],
        'recharge_time' => [
          'type'    => Base::NUM,
          'comment' => 'Tiempo que tarda en volver a disparar'
        ],
        'ignores_shields' => [
          'type'    => Base::BOOL,
          'comment' => 'Indica si el gun esquiva shields 1 o no 0'
        ],
        'energy' => [
          'type'    => Base::NUM,
          'comment' => 'Energía necesaria para que el gun funcione'
        ],
        'credits' => [
          'type'    => Base::NUM,
          'comment' => 'Precio de la gun'
        ],
        'created_at' => [
          'type'    => Base::CREATED,
          'comment' => 'Fecha de creación del registro'
        ],
        'updated_at' => [
          'type'    => Base::UPDATED,
          'comment' => 'Fecha de última modificación del registro'
        ]
    ];

    parent::load($table_name, $model);
  }
}