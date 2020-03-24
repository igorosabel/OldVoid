<?php
class ShipCrew extends OModel{
  function __construct(){
    $table_name = 'ship_crew';
    $model = [
      'id_ship' => [
        'type'    => OCore::PK,
        'comment' => 'Id de la nave donde va el tripulante',
        'incr'    => false
      ],
      'id_crew' => [
        'type'    => OCore::PK,
        'comment' => 'Id del tripulante',
        'incr'    => false
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