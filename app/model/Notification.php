<?php
class Notification extends OBase{
  function __construct(){
    $table_name = 'notification';
    $model = [
        'id' => [
          'type'    => Base::PK,
          'comment' => 'Id única de la notificación'
        ],
        'id_explorer' => [
          'type'    => Base::NUM,
          'comment' => 'Id del explorador que recibe la notificación'
        ],
        'type' => [
          'type'    => Base::NUM,
          'comment' => 'Tipo de notificación'
        ],
        'value' => [
          'type'    => Base::LONGTEXT,
          'comment' => 'Contenido de la notificación'
        ],
        'discarded' => [
          'type'    => Base::BOOL,
          'comment' => 'Indica si la notificación ha sido descartada 1 o no 0'
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