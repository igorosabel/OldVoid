<?php
class Crew extends OModel{
  function __construct(){
    $table_name = 'crew';
    $model = [
        'id' => [
          'type'    => OCore::PK,
          'comment' => 'Id único del tripulante'
        ],
        'name' => [
          'type'    => OCore::TEXT,
          'size'=>50,
          'comment' => 'Nombre del tripulante'
        ],
        'race' => [
          'type'    => OCore::NUM,
          'comment' => 'Id de la raza del tripulante'
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