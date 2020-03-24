<?php
class NPC extends OModel{
  function __construct(){
    $table_name = 'npc';
    $model = [
        'id' => [
          'type'    => OCore::PK,
          'comment' => 'Id único del NPC'
        ],
        'name' => [
          'type'    => OCore::TEXT,
          'size'    => 50,
          'comment' => 'Nombre del NPC'
        ],
        'id_race' => [
          'type'    => OCore::NUM,
          'comment' => 'Id del tipo de raza del NPC'
        ],
        'hulls_start' => [
          'type'    => OCore::TEXT,
          'size'    => 200,
          'comment' => 'Hulls que tiene a la venta por defecto'
        ],
        'hulls_actual' => [
          'type'    => OCore::TEXT,
          'size'    => 200,
          'comment' => 'Hulls que tiene actualmente a la venta'
        ],
        'shields_start' => [
          'type'    => OCore::TEXT,
          'size'    => 200,
          'comment' => 'Shields que tiene a la venta por defecto'
        ],
        'shields_actual' => [
          'type'    => OCore::TEXT,
          'size'    => 200,
          'comment' => 'Shields que tiene actualmente a la venta'
        ],
        'engines_start' => [
          'type'    => OCore::TEXT,
          'size'    => 200,
          'comment' => 'Engines que tiene a la venta por defecto'
        ],
        'engines_actual' => [
          'type'    => OCore::TEXT,
          'size'    => 200,
          'comment' => 'Engines que tiene actualmente a la venta'
        ],
        'generators_start' => [
          'type'    => OCore::TEXT,
          'size'    => 200,
          'comment' => 'Generators que tiene a la venta por defecto'
        ],
        'generators_actual' => [
          'type'    => OCore::TEXT,
          'size'    => 200,
          'comment' => 'Generators que tiene actualmente a la venta'
        ],
        'guns_start' => [
          'type'    => OCore::TEXT,
          'size'    => 200,
          'comment' => 'Armas que tiene a la venta por defecto'
        ],
        'guns_actual' => [
          'type'    => OCore::TEXT,
          'size'    => 200,
          'comment' => 'Armas que tiene actualmente a la venta'
        ],
        'modules_start' => [
          'type'    => OCore::TEXT,
          'size'    => 200,
          'comment' => 'Módulos que tiene a la venta por defecto'
        ],
        'modules_actual' => [
          'type'    => OCore::TEXT,
          'size'    => 200,
          'comment' => 'Módulos que tiene actualmente a la venta'
        ],
        'resources_start' => [
          'type'    => OCore::TEXT,
          'size'    => 200,
          'comment' => 'Recursos que tiene a la venta por defecto'
        ],
        'resources_actual' => [
          'type'    => OCore::TEXT,
          'size'    => 200,
          'comment' => 'Recursos que tiene actualmente a la venta'
        ],
        'last_reset' => [
          'type'    => OCore::DATE,
          'comment' => 'Fecha y hora de la última vez que se ha reseteado'
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