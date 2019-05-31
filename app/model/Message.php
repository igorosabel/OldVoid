<?php
class Message extends OBase{
  function __construct(){
    $table_name = 'message';
    $model = [
        'id' => [
          'type'    => Base::PK,
          'comment' => 'Id único del mensaje'
        ],
        'from' => [
          'type'    => Base::NUM,
          'comment' => 'Id del usuario que envía el mensaje'
        ],
        'to' => [
          'type'    => Base::NUM,
          'comment' => 'Id del usuario que recibe el mensaje'
        ],
        'content' => [
          'type'    => Base::LONGTEXT,
          'comment' => 'Contenido del mensaje'
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