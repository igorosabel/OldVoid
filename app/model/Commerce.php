<?php
class Commerce extends OModel{
  function __construct(){
    $table_name = 'commerce';
    $model = [
        'id' => [
          'type'    => OCore::PK,
          'comment' => 'Id única de la transacción'
        ],
        'id_first' => [
          'type'    => OCore::NUM,
          'comment' => 'Id del explorador que inicia la transacción'
        ],
        'first_offers' => [
          'type'    => OCore::LONGTEXT,
          'comment' => 'Lo que ofrece el primer jugador, json'
        ],
        'first_asks' => [
          'type'    => OCore::LONGTEXT,
          'comment' => 'Lo que pide el primer explorador'
        ],
        'id_second' => [
          'type'    => OCore::NUM,
          'comment' => 'Id del segundo explorador'
        ],
        'second_offers' => [
          'type'    => OCore::LONGTEXT,
          'comment' => 'Lo que ofrece el segundo jugador'
        ],
        'second_asks' => [
          'type'    => OCore::LONGTEXT,
          'comment' => 'Lo que pide el segundo explorador'
        ],
        'status' => [
          'type'    => OCore::NUM,
          'comment' => 'Estado de la transacción, esperando a usuario 1-2, terminada 3, cancelada 4'
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