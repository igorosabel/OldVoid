<?php
class NPC extends OBase{
  function __construct(){
    $table_name = 'npc';
    $model = [
        'id' => [
          'type'    => Base::PK,
          'comment' => 'Id único del NPC'
        ],
        'name' => [
          'type'    => Base::TEXT,
          'size'    => 50,
          'comment' => 'Nombre del NPC'
        ],
        'id_race' => [
          'type'    => Base::NUM,
          'comment' => 'Id del tipo de raza del NPC'
        ],
        'hulls_start' => [
          'type'    => Base::TEXT,
          'size'    => 200,
          'comment' => 'Hulls que tiene a la venta por defecto'
        ],
        'hulls_actual' => [
          'type'    => Base::TEXT,
          'size'    => 200,
          'comment' => 'Hulls que tiene actualmente a la venta'
        ],
        'shields_start' => [
          'type'    => Base::TEXT,
          'size'    => 200,
          'comment' => 'Shields que tiene a la venta por defecto'
        ],
        'shields_actual' => [
          'type'    => Base::TEXT,
          'size'    => 200,
          'comment' => 'Shields que tiene actualmente a la venta'
        ],
        'engines_start' => [
          'type'    => Base::TEXT,
          'size'    => 200,
          'comment' => 'Engines que tiene a la venta por defecto'
        ],
        'engines_actual' => [
          'type'    => Base::TEXT,
          'size'    => 200,
          'comment' => 'Engines que tiene actualmente a la venta'
        ],
        'generators_start' => [
          'type'    => Base::TEXT,
          'size'    => 200,
          'comment' => 'Generators que tiene a la venta por defecto'
        ],
        'generators_actual' => [
          'type'    => Base::TEXT,
          'size'    => 200,
          'comment' => 'Generators que tiene actualmente a la venta'
        ],
        'guns_start' => [
          'type'    => Base::TEXT,
          'size'    => 200,
          'comment' => 'Armas que tiene a la venta por defecto'
        ],
        'guns_actual' => [
          'type'    => Base::TEXT,
          'size'    => 200,
          'comment' => 'Armas que tiene actualmente a la venta'
        ],
        'modules_start' => [
          'type'    => Base::TEXT,
          'size'    => 200,
          'comment' => 'Módulos que tiene a la venta por defecto'
        ],
        'modules_actual' => [
          'type'    => Base::TEXT,
          'size'    => 200,
          'comment' => 'Módulos que tiene actualmente a la venta'
        ],
        'resources_start' => [
          'type'    => Base::TEXT,
          'size'    => 200,
          'comment' => 'Recursos que tiene a la venta por defecto'
        ],
        'resources_actual' => [
          'type'    => Base::TEXT,
          'size'    => 200,
          'comment' => 'Recursos que tiene actualmente a la venta'
        ],
        'last_reset' => [
          'type'    => Base::DATE,
          'comment' => 'Fecha y hora de la última vez que se ha reseteado'
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