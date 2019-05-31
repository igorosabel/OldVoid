<?php
class generateShipTask{
  public function __toString(){
    return "generateShip: Función para crear una nave.";
  }

  private $ship_service = null;

  function __construct(){
    $this->ship_service = new shipService();
  }

  public function run(){
    $explorer = new Explorer();
    $explorer->find(['id'=>1]);

    $s = $this->ship_service->generateShip($explorer);
    echo "\nCREADA NAVE \"".$s->get('name')."\" ( ".$s->get('id')." )\n\n";
  }
}