<?php
class Gun extends OModel{
  function __construct(){
    $table_name = 'gun';
    $model = [
        'id' => [
          'type'    => OCore::PK,
          'comment' => 'Id única del gun'
        ],
        'id_type' => [
          'type'    => OCore::NUM,
          'comment' => 'Id del tipo de gun'
        ],
        'id_owner' => [
          'type'    => OCore::NUM,
          'comment' => 'Id del usuario dueño del gun'
        ],
        'id_ship' => [
          'type'    => OCore::NUM,
          'comment' => 'Id de la nave en la que está equipada o NULL si no está equipada'
        ],
        'strength' => [
          'type'    => OCore::NUM,
          'comment' => 'Daño que hace'
        ],
        'accuracy' => [
          'type'    => OCore::NUM,
          'comment' => 'Indice de acierto del gun'
        ],
        'recharge_time' => [
          'type'    => OCore::NUM,
          'comment' => 'Tiempo que tarda en volver a disparar'
        ],
        'ignores_shields' => [
          'type'    => OCore::BOOL,
          'comment' => 'Indica si el gun esquiva shields 1 o no 0'
        ],
        'energy' => [
          'type'    => OCore::NUM,
          'comment' => 'Energía necesaria para que el gun funcione'
        ],
        'credits' => [
          'type'    => OCore::NUM,
          'comment' => 'Precio de la gun'
        ],
        'created_at' => [
          'type'    => OCore::CREATED,
          'comment' => 'Fecha de creación del registro'
        ],
        'updated_at' => [
          'type'    => OCore::UPDATED,
          'comment' => 'Fecha de última modificación del registro'
        ]
    ];

    parent::load($table_name, $model);
  }
}