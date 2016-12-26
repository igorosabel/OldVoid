<?php
  /*
   * Página temporal, sitio cerrado
   */
  function executeCerrado($req, $t){
    global $c, $s;

    $t->process();
  }

  /*
   * Home pública
   */
  function executeIndex($req, $t){
    global $c, $s;

    $t->add('api_url',$c->getUrl('api'));
    $t->process();
  }
