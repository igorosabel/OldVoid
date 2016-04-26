<?php
  session_start();
  $start_time = microtime(true);
  $where = 'task_generateModel';
  
  include(dirname(__FILE__).'/../config/config.php');
  include($c->getRutaConfig().'gestores.php');
  
  echo "Modelo\n\n";
  $sql = "";
  
  $m = new G_Explorer();
  $sql .= $m->generate();
  $sql .= "\n\n";

  $m = new G_System();
  $sql .= $m->generate();
  $sql .= "\n\n";

  $m = new G_SystemDistance();
  $sql .= $m->generate();
  $sql .= "\n\n";

  $m = new G_ExplorerSystemConnection();
  $sql .= $m->generate();
  $sql .= "\n\n";

  $m = new G_Planet();
  $sql .= $m->generate();
  $sql .= "\n\n";

  $m = new G_Moon();
  $sql .= $m->generate();
  $sql .= "\n\n";

  $m = new G_Ship();
  $sql .= $m->generate();
  $sql .= "\n\n";

  $m = new G_Gun();
  $sql .= $m->generate();
  $sql .= "\n\n";

  $m = new G_Module();
  $sql .= $m->generate();
  $sql .= "\n\n";

  $m = new G_NPC();
  $sql .= $m->generate();
  $sql .= "\n\n";

  $m = new G_Resources();
  $sql .= $m->generate();
  $sql .= "\n\n";

  $m = new G_ShipCrew();
  $sql .= $m->generate();
  $sql .= "\n\n";

  $m = new G_Crew();
  $sql .= $m->generate();
  $sql .= "\n\n";

  echo $sql;

  $ruta = $c->getRutaSQL()."model.sql";
  if (file_exists($ruta)){
    unlink($ruta);
  }
  file_put_contents($ruta,$sql);