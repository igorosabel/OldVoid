<?php
class Message extends OModel{
  function __construct(){
    $table_name = 'message';
    $model = [
        'id' => [
          'type'    => OCore::PK,
          'comment' => 'Id único del mensaje'
        ],
        'from' => [
          'type'    => OCore::NUM,
          'comment' => 'Id del usuario que envía el mensaje'
        ],
        'to' => [
          'type'    => OCore::NUM,
          'comment' => 'Id del usuario que recibe el mensaje'
        ],
        'content' => [
          'type'    => OCore::LONGTEXT,
          'comment' => 'Contenido del mensaje'
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