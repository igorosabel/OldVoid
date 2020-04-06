<?php
class generalService extends OService{
  function __construct(){
    $this->loadService();
  }

  public function generateAuth(){
    return substr(sha1('v_'.time().'_v'), 0, 32);
  }

  public function getNotifications($ex){
    $db = new ODB();
    $sql = "SELECT * FROM `notification` WHERE `id_explorer` = ? AND `discarded` = 0";

    $ret = [];
    $db->query($sql, [$ex->get('id')]);
    while ($res=$db->next()){
      $notification = new Notification();
      $notification->update($res);

      array_push($ret, $notification);
    }

    return $ret;
  }

  public function getResourceName($id){
    $resources = OTools::getCache('resource');

    foreach ($resources['resources'] as $res){
      if ($res['id']==$id){
        return $res['name'];
      }
    }

    return '';
  }
}