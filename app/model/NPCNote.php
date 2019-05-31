<?php
class NPCNote extends OBase{
  function __construct(){
    $table_name = 'npc_note';
    $model = [
        'id' => [
          'type'    => Base::PK,
          'comment' => 'Id única de la nota'
        ],
        'id_explorer' => [
          'type'    => Base::NUM,
          'comment' => 'Id del usuario que pone la nota'
        ],
        'id_npc' => [
          'type'    => Base::NUM,
          'comment' => 'Id del NPC que tiene la nota'
        ],
        'note' => [
          'type'    => Base::LONGTEXT,
          'comment' => 'Nota que el explorador pone al NPC'
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