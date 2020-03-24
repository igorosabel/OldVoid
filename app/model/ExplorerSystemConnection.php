<?php
class ExplorerSystemConnection extends OModel{
  function __construct(){
    $table_name = 'explorer_system_connection';
    $model = [
        'id_explorer' => [
          'type'    => OCore::PK,
          'comment' => 'Id del explorador',
          'incr'    => false
        ],
        'id_system_1' => [
          'type'    => OCore::PK,
          'comment' => 'Id del primer sistema',
          'incr'    => false
        ],
        'id_system_2' => [
          'type'    => OCore::PK,
          'comment' => 'Id del segundo sistema',
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