<?php
  /* Datos generales */
  date_default_timezone_set('Europe/Madrid');

  $basedir = realpath(dirname(__FILE__));
  $basedir = str_ireplace('config','',$basedir);

  require($basedir.'model/base/OConfig.php');
  $c = new OConfig();
  $c->setBaseDir($basedir);
  
  /* Carga de módulos */
  $c->loadDefaultModules();
  
  /* Carga de paquetes */
  //$c->loadPackages();

  /* Datos de la Base De Datos */
  $c->setDB('host', 'localhost');
  $c->setDB('user', 'void');
  $c->setDB('pass', '2Rojg$20');
  $c->setDB('name', 'void');
  
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
  $c->setCssList( array('angular-material.min', 'void') );
  
  /* Lista de JavaScript por defecto */
  $c->setJsList( array() );
  
  /* Título de la página */
  $c->setDefaultTitle('Void');

  /* Idioma de la página */
  $c->setLang('es');
  
  /* Extra */
  $c->setExtra('max_connections',        3);
  $c->setExtra('life_bonus',             2);
  $c->setExtra('max_npc',                2);
  $c->setExtra('npc_prob',               3);
  $c->setExtra('system_name_chars',      3);
  $c->setExtra('system_name_nums',       3);
  $c->setExtra('default_ship_hull',      1);
  $c->setExtra('default_ship_shield',    1);
  $c->setExtra('default_ship_engine',    1);
  $c->setExtra('default_ship_generator', 1);
  $c->setExtra('default_gun',            1);
  $c->setExtra('default_modules',        array(1,2));
  $c->setExtra('max_sell_hulls',         2);
  $c->setExtra('max_sell_shields',       2);
  $c->setExtra('max_sell_engines',       2);
  $c->setExtra('max_sell_generators',    2);
  $c->setExtra('max_sell_guns',          2);
  $c->setExtra('max_sell_modules',       2);
  $c->setExtra('max_sell_crew',          2);
  $c->setExtra('max_sell_resources',     4);