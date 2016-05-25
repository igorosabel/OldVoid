<?php
class General{
  public static function generateAuth(){
    return substr(sha1('v_'.time().'_v'), 0, 32);
  }

  public static function getNotifications($ex){
    $db = new G_DB();
    $sql = "SELECT * FROM `notification` WHERE `id_explorer` = ".$ex->get('id')." AND `discarded` = 0";

    $ret = array();
    $db->query($sql);
    while ($res=$db->next()){
      $notification = new G_Notification();
      $notification->update($res);

      array_push($ret,$notification);
    }

    return $ret;
  }
  
  public static function getResourceName($id){
    $resources = Base::getCache('resource');
    
    foreach ($resources['resources'] as $res){
      if ($res['id']==$id){
        return $res['name'];
      }
    }
    
    return '';
  }
}