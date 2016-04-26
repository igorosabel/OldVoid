<?php
  session_start();
  $start_time = microtime(true);
  $where = 'task_navigate';

  include(dirname(__FILE__).'/../config/config.php');
  include($c->getRutaConfig().'gestores.php');

  $explorer = new G_Explorer();
  $explorer->buscar(array('id'=>1));

  $from = new G_System();
  $from->buscar(array('id'=>1));

  General::goToSystem($explorer,$from,null);