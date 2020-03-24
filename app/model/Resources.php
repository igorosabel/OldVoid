<?php
class Resources extends OModel{
  function __construct(){
    $table_name = 'resources';
    $model = [
      'id_planet' => [
        'type'    => OCore::PK,
        'comment' => 'Id del planeta donde está el recurso o NULL si es una luna',
        'incr'    => false
      ],
      'id_moon' => [
        'type'    => OCore::PK,
        'comment' => 'Id de la luna donde está el recurso o NULL si es un planeta',
        'incr'    => false
      ],
      'id_resource_type' => [
        'type'    => OCore::PK,
        'comment' => 'Id del tipo de recurso',
        'incr'    => false
      ],
      'value' => [
        'type'    => OCore::NUM,
        'comment' => 'Cantidad de recursos que hay'
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