<?php
class jobService extends OService{
  function __construct($controller=null){
    $this->setController($controller);
  }

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

  public function checkJob($id_job){
    $job = new Job();
    $job->find(['id'=>$id_job]);
    if (time()>($job->get('start')+$job->get('duration'))){
      $job->setStatus(self::STATUS_FINISHED);
    }
    else{
      $job->setStatus(self::STATUS_WORKING);
    }

    return $job;
  }

  public function getUnfinishedJobs(){
    $db = $this->getController()->getDb();
    $sql = "SELECT * FROM `explorer` WHERE `id_job` IS NOT NULL";

    $db->query($sql);
    $ret = [];

    while($res=$db->next()){
      $explorer = new Explorer();
      $explorer->update($res);

      array_push($ret, $explorer);
    }

    return $ret;
  }

  public static function getJobName($type){
    switch($type){
      case $this->EXPLORE:{
        return $this->EXPLORE_NAME;
      }
      case $this->JUMP:{
        return $this->JUMP_NAME;
      }
      case $this->RESOURCES:{
        return $this->RESOURCES_NAME;
      }
    }
    return '';
  }
}