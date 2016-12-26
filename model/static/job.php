<?php
class stJob{
  /*
    Tipos de trabajos
  */
  const EXPLORE         = 1;
  const EXPLORE_NAME    = 'Exploración';
  const JUMP            = 2;
  const JUMP_NAME       = 'Navegación';
  const RESOURCES       = 3;
  const RESOURCES_NAME  = 'Obtener recursos';
  
  const STATUS_WORKING  = 1;
  const STATUS_FINISHED = 2;
  
  public static function checkJob($id_job){
    $job = new Job();
    $job->find(array('id'=>$id_job));
    if (time()>($job->get('start')+$job->get('duration'))){
      $job->setStatus(self::STATUS_FINISHED);
    }
    else{
      $job->setStatus(self::STATUS_WORKING);
    }
    
    return $job;
  }
  
  public static function getUnfinishedJobs(){
    $db = new ODB();
    $sql = "SELECT * FROM `explorer` WHERE `id_job` IS NOT NULL";
    
    $db->query($sql);
    $ret = array();
    
    while($res=$db->next()){
      $explorer = new Explorer();
      $explorer->update($res);
      
      array_push($ret, $explorer);
    }
    
    return $ret;
  }

  public static function getJobName($type){
    switch($type){
      case self::EXPLORE:{
        return self::EXPLORE_NAME;
      }
      case self::JUMP:{
        return self::JUMP_NAME;
      }
      case self::RESOURCES:{
        return self::RESOURCES_NAME;
      }
    }
    return '';
  }
}