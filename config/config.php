<?php
  /* Datos generales */
  date_default_timezone_set('Europe/Madrid');

  $ruta_base = realpath(dirname(__FILE__));
  $ruta_base = str_ireplace("config","",$ruta_base);

  include($ruta_base."gestores/base/G_Config.php");
  $c = new G_Config();
  $c->setRutaBase($ruta_base);

  /* Datos de la Base De Datos */
  $c->setDbHost('localhost');
  $c->setDbUser('void');
  $c->setDbPass('2Rojg$20');
  $c->setDbName('void');
  
  /* Activa/desactiva el modo debug que guarda en log las consultas SQL e información variada */
  $c->setModoDebug(false);

  /* URL del sitio */
  $c->setUrlBase('https://void.osumi.es/');
  
  /* Email del administrador al que se notificarán varios eventos */
  $c->setAdminEmail('inigo.gorosabel@gmail.com');
  
  /* Lista de CSS por defecto */
  $css = array('void');
  $c->setCssList( $css );
  
  /* Lista de JavaScript por defecto */
  $js = array('lib/common');
  $c->setJsList( $js );
  
  /* Título de la página */
  $c->setDefaultTitle('Void');

  /* Idioma de la página */
  $c->setLang('es');