<?php
class Resources extends OBase{
  function __construct(){
    $table_name = 'resources';
    $model = [
      'id_planet' => [
        'type'    => Base::PK,
        'comment' => 'Id del planeta donde está el recurso o NULL si es una luna',
        'incr'    => false
      ],
      'id_moon' => [
        'type'    => Base::PK,
        'comment' => 'Id de la luna donde está el recurso o NULL si es un planeta',
        'incr'    => false
      ],
      'id_resource_type' => [
        'type'    => Base::PK,
        'comment' => 'Id del tipo de recurso',
        'incr'    => false
      ],
      'value' => [
        'type'    => Base::NUM,
        'comment' => 'Cantidad de recursos que hay'
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