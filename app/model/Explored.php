<?php
class Explored extends OBase{
  function __construct(){
    $table_name = 'explored';
    $model = [
      'id_explorer' => [
        'type'    => Base::PK,
        'comment' => 'Id del explorador',
        'incr'    => false
      ],
      'id_planet' => [
        'type'    => Base::PK,
        'comment' => 'Id del planeta explorado o null si es una luna',
        'incr'    => false
      ],
      'id_moon' => [
        'type'    => Base::PK,
        'comment' => 'Id de la luna explorada o null si es un planeta',
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