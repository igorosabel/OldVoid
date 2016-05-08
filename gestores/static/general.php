<?php
class General{
  public static function generateAuth(){
    return substr(sha1('v_'.time().'_v'), 0, 32);
  }

  public static function getNotifications($ex){
    $bd = new G_BBDD();
    $sql = "SELECT * FROM `notification` WHERE `id_explorer` = '".$ex->get('id')."' AND `discarded` = 0";

    $ret = array();
    $bd->consulta($sql);
    while ($res=$bd->sig()){
      $notification = new G_Notification();
      $notification->actualizar($res);

      array_push($ret,$notification);
    }

    return $ret;
  }
}