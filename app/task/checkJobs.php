<?php
class checkJobsTask{
  public function __toString(){
    return "checkJobs: Función para limpiar jobs completados.";
  }

  private $job_service = null;

  function __construct(){
    $this->job_service = new jobService();
  }

  public function run(){
    // Cojo todos los exploradores con trabajos pendientes
    $explorers = $this->job_service->getUnfinishedJobs();

    // Recorro todos los trabajadores
    foreach ($explorers as $explorer){
      // Compruebo el trabajo pendiente del explorador
      $job = $this->job_service->checkJob($explorer->get('id_job'));

      // Si el trabajo ya ha terminado
      if ($job->getStatus()==jobService::STATUS_FINISHED){
        // Le quito el trabajo pendiente al explorador
        $explorer->set('id_job',null);
        $explorer->save();

        $job->jobDone();
      }
    }
  }
}