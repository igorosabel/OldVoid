<?php
class G_NPCNote extends G_Base{
  function __construct(){
    $model_name = 'G_NPCNote';
    $tablename  = 'npc_note';
    $model = array(
        'id'          => array('type'=>Base::PK,      'com'=>'Id única de la nota'),
        'id_explorer' => array('type'=>Base::NUM,     'com'=>'Id del usuario que pone la nota'),
        'id_npc'      => array('type'=>Base::NUM,     'com'=>'Id del NPC que tiene la nota'),
        'note'        => array('type'=>Base::TEXTO,   'len'=>1000, 'com'=>'Nota que el explorador pone al NPC'),
        'created_at'  => array('type'=>Base::CREATED, 'com'=>'Fecha de creación del registro'),
        'updated_at'  => array('type'=>Base::UPDATED, 'com'=>'Fecha de última modificación del registro')
    );

    parent::load($model_name,$tablename,$model);
  }
}