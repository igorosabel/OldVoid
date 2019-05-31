<?php
class generateCharacterJSONTask{
  public function __toString(){
    return "generateCharacterJSON: Función para generar NPCs.";
  }

  public function run(){
    global $c;

    $ruta_csv = $c->getDir('cache').'characters.csv';
    $list = file_get_contents($ruta_csv);
    $names = explode(',',$list);

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

    $ruta_json = $c->getDir('cache')."npc.json";
    if (file_exists($ruta_json)){
      unlink($ruta_json);
    }
    file_put_contents($ruta_json,$json);
  }
}