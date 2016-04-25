<?php
  session_start();
  $start_time = microtime(true);
  $where = 'task_prueba';
  
  include(dirname(__FILE__).'/../config/config.php');
  include($c->getRutaConfig().'gestores.php');
  
  General::generateSystem();