<?php
  session_start();
  $start_time = microtime(true);
  $where = 'task_checkJobs';
  
  include(dirname(__FILE__).'/../config/config.php');
  include($c->getDir('config').'model.php');

  // Cojo todos los exploradores con trabajos pendientes
  $explorers = stJob::getUnfinishedJobs();
  
  // Recorro todos los trabajadores
  foreach ($explorers as $explorer){
    // Compruebo el trabajo pendiente del explorador
    $job = stJob::checkJob($explorer->get('id_job'));

    // Si el trabajo ya ha terminado
    if ($job->getStatus()==stJob::STATUS_FINISHED){
      // Le quito el trabajo pendiente al explorador
      $explorer->set('id_job',null);
      $explorer->save();

      $job->jobDone();
    }
  }