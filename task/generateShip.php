<?php
  session_start();
  $start_time = microtime(true);
  $where = 'task_generateShip';
  
  include(dirname(__FILE__).'/../config/config.php');
  include($c->getRutaConfig().'gestores.php');

  $explorer = new G_Explorer();
  $explorer->find(array('id'=>1));

  $s = General::generateShip($explorer);
  echo "\nCREADA NAVE \"".$s->get('name')."\" ( ".$s->get('id')." )\n\n";