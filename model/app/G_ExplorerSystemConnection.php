<?php
class G_ExplorerSystemConnection extends G_Base{
  function __construct(){
    $model_name = 'G_ExplorerSystemConnection';
    $tablename  = 'explorer_system_connection';
    $model = array(
        'id_explorer' => array('type'=>Base::PK,      'com'=>'Id del explorador',      'incr'=>false),
        'id_system_1' => array('type'=>Base::PK,      'com'=>'Id del primer sistema',  'incr'=>false),
        'id_system_2' => array('type'=>Base::PK,      'com'=>'Id del segundo sistema', 'incr'=>false),
        'created_at'  => array('type'=>Base::CREATED, 'com'=>'Fecha de creación del registro'),
        'updated_at'  => array('type'=>Base::UPDATED, 'com'=>'Fecha de última modificación del registro')
    );

    parent::load($model_name,$tablename,$model,array('id_explorer','id_system_1','id_system_2'));
  }
}