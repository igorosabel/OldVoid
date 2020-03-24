<?php
class Notification extends OModel{
  function __construct(){
    $table_name = 'notification';
    $model = [
        'id' => [
          'type'    => OCore::PK,
          'comment' => 'Id única de la notificación'
        ],
        'id_explorer' => [
          'type'    => OCore::NUM,
          'comment' => 'Id del explorador que recibe la notificación'
        ],
        'type' => [
          'type'    => OCore::NUM,
          'comment' => 'Tipo de notificación'
        ],
        'value' => [
          'type'    => OCore::LONGTEXT,
          'comment' => 'Contenido de la notificación'
        ],
        'discarded' => [
          'type'    => OCore::BOOL,
          'comment' => 'Indica si la notificación ha sido descartada 1 o no 0'
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