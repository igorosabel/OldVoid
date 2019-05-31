<?php
class Commerce extends OBase{
  function __construct(){
    $table_name = 'commerce';
    $model = [
        'id' => [
          'type'    => Base::PK,
          'comment' => 'Id única de la transacción'
        ],
        'id_first' => [
          'type'    => Base::NUM,
          'comment' => 'Id del explorador que inicia la transacción'
        ],
        'first_offers' => [
          'type'    => Base::LONGTEXT,
          'comment' => 'Lo que ofrece el primer jugador, json'
        ],
        'first_asks' => [
          'type'    => Base::LONGTEXT,
          'comment' => 'Lo que pide el primer explorador'
        ],
        'id_second' => [
          'type'    => Base::NUM,
          'comment' => 'Id del segundo explorador'
        ],
        'second_offers' => [
          'type'    => Base::LONGTEXT,
          'comment' => 'Lo que ofrece el segundo jugador'
        ],
        'second_asks' => [
          'type'    => Base::LONGTEXT,
          'comment' => 'Lo que pide el segundo explorador'
        ],
        'status' => [
          'type'    => Base::NUM,
          'comment' => 'Estado de la transacción, esperando a usuario 1-2, terminada 3, cancelada 4'
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