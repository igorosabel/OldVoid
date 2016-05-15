<?php
class Job{
  /*
    Tipos de trabajos
  */
  const EXPLORE         = 1;
  const JUMP            = 2;
  const RESOURCES       = 3;
  
  const STATUS_WORKING  = 1;
  const STATUS_FINISHED = 2;
  
  public static function checkJob($id_job){
    $job = new G_Job();
    $job->buscar(array('id'=>$id_job));
    if (time()>($job->get('start')+$job->get('duration'))){
      $job->setStatus(self::STATUS_FINISHED);
    }
    else{
      $job->setStatus(self::STATUS_WORKING);
    }
    
    return $job;
  }
  
  public static function getUnfinishedJobs(){
    $bd = new G_BBDD();
    $sql = "SELECT * FROM `explorer` WHERE `id_job` IS NOT NULL";
    
    $bd->consulta($sql);
    $ret = array();
    
    while($res=$bd->sig()){
      $explorer = new G_Explorer();
      $explorer->actualizar($res);
      
      array_push($ret, $explorer);
    }
    
    return $ret;
  }

  public static function getJobName($type){
    switch($type){
      case self::EXPLORE:{
        return "Exploración";
      }
      case self::JUMP:{
        return "Navegación";
      }
      case self::RESOURCES:{
        return "Obtener recursos";
      }
    }
    return "";
  }
}