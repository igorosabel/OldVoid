<?php
  /*
    Página temporal, sitio cerrado
  */
  function executeCerrado($req, $t){
    /*
      Código de la página
    */
    global $c, $s;

    $t->process();
  }

  /*
    Home pública
  */
  function executeIndex($req, $t){
    /*
      Código de la página
    */
    global $c, $s;

    $t->add('api_url',$c->getApiUrl());
    $t->process();
  }
