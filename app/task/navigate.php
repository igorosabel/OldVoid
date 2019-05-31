<?php
class navigateºTask{
  public function __toString(){
    return "navigate: Función para ir a un sistema.";
  }

  private $system_service = null;

  function __construct(){
    $this->system_service = new systemService();
  }

  public function run(){
    $explorer = new Explorer();
    $explorer->find(['id'=>1]);

    $from = new System();
    $from->find(['id'=>1]);

    $this->system_service->goToSystem($explorer, $from, null);
  }
}