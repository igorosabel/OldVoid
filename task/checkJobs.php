<?php
  session_start();
  $start_time = microtime(true);
  $where = 'task_checkJobs';
  
  include(dirname(__FILE__).'/../config/config.php');
  include($c->getRutaConfig().'gestores.php');

  // Cojo todos los exploradores con trabajos pendientes
  $explorers = Job::getUnfinishedJobs();
  
  // Recorro todos los trabajadores
  foreach ($explorers as $explorer){
    // Compruebo el trabajo pendiente del explorador
    $job = Job::checkJob($explorer->get('id_job'));

    // Si el trabajo ya ha terminado
    if ($job->getStatus()==Job::STATUS_FINISHED){
      // Le quito el trabajo pendiente al explorador
      $explorer->set('id_job',null);
      $explorer->salvar();

      $job->jobDone();
    }
  }