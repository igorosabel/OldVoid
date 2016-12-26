<?php
  /* Datos generales */
  date_default_timezone_set('Europe/Madrid');

  $basedir = realpath(dirname(__FILE__));
  $basedir = str_ireplace("config","",$basedir);

  require($basedir."model/base/G_Config.php");
  $c = new G_Config();
  $c->setBaseDir($basedir);
  
  /* Carga de módulos */
  $c->loadDefaultFwModules();

  /* Datos de la Base De Datos */
  $c->setDbHost('localhost');
  $c->setDbUser('void');
  $c->setDbPass('2Rojg$20');
  $c->setDbName('void');
  
  /* Datos para cookies */
  $c->setCookiePrefix('void');
  $c->setCookieUrl('.osumi.es');
  
  /* Activa/desactiva el modo debug que guarda en log las consultas SQL e información variada */
  $c->setDebugMode(false);

  /* URL del sitio */
  $c->setBaseUrl('https://void.osumi.es/');
  
  /* Email del administrador al que se notificarán varios eventos */
  $c->setAdminEmail('inigo.gorosabel@gmail.com');
  
  /* Lista de CSS por defecto */
  $c->setCssList( array('angular-material.min','void') );
  
  /* Lista de JavaScript por defecto */
  $c->setJsList( array() );
  
  /* Título de la página */
  $c->setDefaultTitle('Void');

  /* Idioma de la página */
  $c->setLang('es');