<?php
class ShipCrew extends OBase{
  function __construct(){
    $table_name = 'ship_crew';
    $model = [
      'id_ship' => [
        'type'    => Base::PK,
        'comment' => 'Id de la nave donde va el tripulante',
        'incr'    => false
      ],
      'id_crew' => [
        'type'    => Base::PK,
        'comment' => 'Id del tripulante',
        'incr'    => false
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