<?php
session_start();
$start_time = microtime(true);
$where = 'task_generateCharacterJSON';

include(dirname(__FILE__).'/../config/config.php');
include($c->getRutaConfig().'gestores.php');

$ruta_csv = $c->getRutaCache().'characters.csv';
$list = file_get_contents($ruta_csv);
$names = explode(",",$list);

$json  = "{\n";
$json .= "  \"info\": \"http://www.starwars.com/databank\",\n";
$json .= "  \"character_list\": [\n";

foreach ($names as $i => $item){
  $json .= "    \"".$item."\"";
  if ($i<count($names)-1){ $json .= ","; }
  $json .= "\n";
}

$json .= "  ]\n";
$json .= "}";

$ruta_json = $c->getRutaCache()."npc.json";
if (file_exists($ruta_json)){
  unlink($ruta_json);
}
file_put_contents($ruta_json,$json);