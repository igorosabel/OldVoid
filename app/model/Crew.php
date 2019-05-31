<?php
class Crew extends OBase{
  function __construct(){
    $table_name = 'crew';
    $model = [
        'id' => [
          'type'    => Base::PK,
          'comment' => 'Id único del tripulante'
        ],
        'name' => [
          'type'    => Base::TEXT,
          'size'=>50,
          'comment' => 'Nombre del tripulante'
        ],
        'race' => [
          'type'    => Base::NUM,
          'comment' => 'Id de la raza del tripulante'
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