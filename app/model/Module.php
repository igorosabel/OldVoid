<?php
class Module extends OBase{
  function __construct(){
    $table_name = 'module';
    $model = [
        'id' => [
          'type'    => Base::PK,
          'comment' => 'Id único del módulo'
        ],
        'id_type' => [
          'type'    => Base::NUM,
          'comment' => 'Id del tipo de módulo'
        ],
        'id_owner' => [
          'type'    => Base::NUM,
          'comment' => 'Id del usuario dueño del módulo'
        ],
        'id_ship' => [
          'type'    => Base::NUM,
          'comment' => 'Id de la nave en la que está equipada o NULL si no está equipada'
        ],
        'size' => [
          'type'    => Base::NUM,
          'comment' => 'Tamaño del módulo 0 small 1 big
          '],
        'enables' => [
          'type'    => Base::TEXT,
          'size'    => 100,
          'comment' => 'Lista de habilidades que tener el módulo permite'
        ],
        'crew' => [
          'type'    => Base::NUM,
          'comment' => 'Número de tripulantes que puede alojar o pueden trabajar'
        ],
        'mass' => [
          'type'    => Base::NUM,
          'comment' => 'Peso del módulo, para el movimiento'
        ],
        'storage_capacity' => [
          'type'    => Base::NUM,
          'comment' => 'Capacidad de almacenamiento del módulo'
        ],
        'storage' => [
          'type'    => Base::TEXT,
          'size'    => 200,
          'comment' => 'Recursos almacenados'
        ],
        'energy' => [
          'type'    => Base::NUM,
          'comment' => 'Energía necesaria para que el módulo funcione'
        ],
        'credits' => [
          'type'    => Base::NUM,
          'comment' => 'Precio del módulo'
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