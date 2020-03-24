<?php
class Explored extends OModel{
  function __construct(){
    $table_name = 'explored';
    $model = [
      'id_explorer' => [
        'type'    => OCore::PK,
        'comment' => 'Id del explorador',
        'incr'    => false
      ],
      'id_planet' => [
        'type'    => OCore::PK,
        'comment' => 'Id del planeta explorado o null si es una luna',
        'incr'    => false
      ],
      'id_moon' => [
        'type'    => OCore::PK,
        'comment' => 'Id de la luna explorada o null si es un planeta',
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