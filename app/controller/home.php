<?php
class home extends OController{
  /*
   * Página temporal, sitio cerrado
   */
  function cerrado($req){}

  /*
   * Home pública
   */
  function index($req){
    $this->getTemplate()->add('api_url', $this->getConfig()->getUrl('api'));
  }
}