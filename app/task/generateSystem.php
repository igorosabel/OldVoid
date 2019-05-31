<?php
class generateSystemTask{
  public function __toString(){
    return "generateSystem: Función para crear un sistema.";
  }

  private $system_service = null;

  function __construct(){
    $this->system_service = new systemService();
  }

  public function run(){
    $explorer = new Explorer();
    $explorer->find(['id'=>1]);

    $s = $this->system_service->generateSystem($explorer);
    echo "\nCREADO SISTEMA \"".$s->get('name')."\" ( ".$s->get('id')." )\n\n";
  }
}