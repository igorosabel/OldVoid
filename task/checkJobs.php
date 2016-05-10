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

      // Cojo datos del trabajo
      $data = json_decode($job->get('value'),true);
      
      // Si el trabajo era de exploración, marco el planeta como explorado
      if ($job->get('type')==Job::EXPLORE){
        $explored = new G_Explored();
        $explored->set('id_explorer',$explorer->get('id'));
        if ($data['type']=='planet') {
          $explored->set('id_moon', 0);
          $explored->set('id_planet', $data['id']);
        }
        if ($data['type']=='moon') {
          $explored->set('id_moon', $data['id']);
          $explored->set('id_planet', 0);
        }
  
        $explored->salvar();
      }
    }
  }