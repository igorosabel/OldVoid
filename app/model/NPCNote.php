<?php
class NPCNote extends OModel{
  function __construct(){
    $table_name = 'npc_note';
    $model = [
        'id' => [
          'type'    => OCore::PK,
          'comment' => 'Id única de la nota'
        ],
        'id_explorer' => [
          'type'    => OCore::NUM,
          'comment' => 'Id del usuario que pone la nota'
        ],
        'id_npc' => [
          'type'    => OCore::NUM,
          'comment' => 'Id del NPC que tiene la nota'
        ],
        'note' => [
          'type'    => OCore::LONGTEXT,
          'comment' => 'Nota que el explorador pone al NPC'
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