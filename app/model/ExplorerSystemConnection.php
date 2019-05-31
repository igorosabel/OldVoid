<?php
class ExplorerSystemConnection extends OBase{
  function __construct(){
    $table_name = 'explorer_system_connection';
    $model = [
        'id_explorer' => [
          'type'    => Base::PK,
          'comment' => 'Id del explorador',
          'incr'    => false
        ],
        'id_system_1' => [
          'type'    => Base::PK,
          'comment' => 'Id del primer sistema',
          'incr'    => false
        ],
        'id_system_2' => [
          'type'    => Base::PK,
          'comment' => 'Id del segundo sistema',
          'incr'    => false
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