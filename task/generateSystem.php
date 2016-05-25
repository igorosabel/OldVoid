<?php
  session_start();
  $start_time = microtime(true);
  $where = 'task_generateSystem';
  
  include(dirname(__FILE__).'/../config/config.php');
  include($c->getRutaConfig().'gestores.php');

  $explorer = new G_Explorer();
  $explorer->find(array('id'=>1));

  $s = General::generateSystem($explorer);
  echo "\nCREADO SISTEMA \"".$s->get('name')."\" ( ".$s->get('id')." )\n\n";