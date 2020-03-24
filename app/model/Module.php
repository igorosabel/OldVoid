<?php
class Module extends OModel{
  function __construct(){
    $table_name = 'module';
    $model = [
        'id' => [
          'type'    => OCore::PK,
          'comment' => 'Id único del módulo'
        ],
        'id_type' => [
          'type'    => OCore::NUM,
          'comment' => 'Id del tipo de módulo'
        ],
        'id_owner' => [
          'type'    => OCore::NUM,
          'comment' => 'Id del usuario dueño del módulo'
        ],
        'id_ship' => [
          'type'    => OCore::NUM,
          'comment' => 'Id de la nave en la que está equipada o NULL si no está equipada'
        ],
        'size' => [
          'type'    => OCore::NUM,
          'comment' => 'Tamaño del módulo 0 small 1 big
          '],
        'enables' => [
          'type'    => OCore::TEXT,
          'size'    => 100,
          'comment' => 'Lista de habilidades que tener el módulo permite'
        ],
        'crew' => [
          'type'    => OCore::NUM,
          'comment' => 'Número de tripulantes que puede alojar o pueden trabajar'
        ],
        'mass' => [
          'type'    => OCore::NUM,
          'comment' => 'Peso del módulo, para el movimiento'
        ],
        'storage_capacity' => [
          'type'    => OCore::NUM,
          'comment' => 'Capacidad de almacenamiento del módulo'
        ],
        'storage' => [
          'type'    => OCore::TEXT,
          'size'    => 200,
          'comment' => 'Recursos almacenados'
        ],
        'energy' => [
          'type'    => OCore::NUM,
          'comment' => 'Energía necesaria para que el módulo funcione'
        ],
        'credits' => [
          'type'    => OCore::NUM,
          'comment' => 'Precio del módulo'
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