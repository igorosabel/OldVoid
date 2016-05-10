<?php
class System{
  public static function getSystemColor($type){
    $type_data = split("-", $type);
    $system = Base::getCache('system');
    $ret = '#000';
    foreach ($system['spectral_types'] as $stype){
      if ($stype['type']==$type_data[1]){
        $ret = $stype['color'];
        break;
      }
    }
    
    return $ret;
  }

  public static function getExplorersInSystem($explorer,$id_system){
    $bd = new G_BBDD();
    $sql = "SELECT COUNT(*) AS `num` FROM `explorer` WHERE `last_save_point` = '".$id_system."'";
    if (!is_null($explorer)) {
      $sql .= " AND `id` != '" . $explorer->get('id') . "'";
    }
    $bd->consulta($sql);

    if ($res = $bd->sig()){
      return $res['num'];
    }
    else{
      return 0;
    }
  }
  
  public static function getPeopleInSystem($id){
    $bd = new G_BBDD();

    $ret = array('npc'=>array(),'explorer'=>array());

    // NPC en planetas
    $sql = "SELECT a.*, b.`name` AS `planet_name` FROM `npc` a, `planet` b WHERE a.`id` = b.`id_owner` AND b.`npc` = 1 AND b.`id_system` = ".$id;

    $bd->consulta($sql);
    while ($res=$bd->sig()){
      $npc = new G_NPC();
      $npc->actualizar($res);

      array_push($ret['npc'],array('npc'=>$npc,'where'=>$res['planet_name']));
    }

    // NPC en lunas
    $sql = "SELECT a.*, c.`name` AS `moon_name` FROM `npc` a, `planet` b, `moon` c WHERE a.`id` = c.`id_owner` AND c.`npc` = 1 AND c.`id_planet` = b.`id` AND b.`id_system` = ".$id;

    $bd->consulta($sql);
    while ($res=$bd->sig()){
      $npc = new G_NPC();
      $npc->actualizar($res);

      array_push($ret['npc'],array('npc'=>$npc,'where'=>$res['moon_name']));
    }

    // Exploradores en el sistema
    $sql = "SELECT a.*, b.`name` AS `system_name` FROM `explorer` a, `system` b WHERE a.`last_save_point` = b.`id` AND b.`id` = ".$id;

    $bd->consulta($sql);
    while ($res=$bd->sig()){
      $ex = new G_Explorer();
      $ex->actualizar($res);

      array_push($ret['explorer'],array('explorer'=>$ex,'where'=>$res['system_name']));
    }

    return $ret;
  }
  
  public static function loadPlanets($explorer,$system){
    $bd = new G_BBDD();
    $ret = array();
    
    $sql = "SELECT * FROM `planet` WHERE `id_system` = ".$system->get('id')." ORDER BY `distance` ASC";
    $bd->consulta($sql);
    
    while ($res=$bd->sig()){
      $planet = new G_Planet();
      $planet->actualizar($res);

      // Busco NPC en el planeta
      if ($planet->get('npc')){
        $planet->setNpc(NPC::loadNPC($planet->get('id_owner')));
      }

      // Compruebo si el planeta ya ha sido explorado
      $explored = new G_Explored();
      if ($explored->buscar(array(
        'id_explorer' => $explorer->get('id'),
        'id_planet' =>$planet->get('id')
      ))){
        $planet->setExplored(true);
      }

      // Cargo lunas del planeta
      $planet->setMoons(self::loadMoons($explorer,$planet));

      array_push($ret, $planet);
    }
    
    return $ret;
  }
  
  public static function loadMoons($explorer,$planet){
    $bd = new G_BBDD();
    $ret = array();
    
    $sql = "SELECT * FROM `moon` WHERE `id_planet` = ".$planet->get('id')." ORDER BY `distance` ASC";
    $bd->consulta($sql);
    
    while ($res=$bd->sig()){
      $moon = new G_Moon();
      $moon->actualizar($res);

      // Busco NPC en la luna
      if ($moon->get('npc')){
        $moon->setNpc(NPC::loadNPC($moon->get('id_owner')));
      }

      // Compruebo si el planeta ya ha sido explorado
      $explored = new G_Explored();
      if ($explored->buscar(array(
        'id_explorer' => $explorer->get('id'),
        'id_moon' =>$moon->get('id')
      ))){
        $moon->setExplored(true);
      }
      
      array_push($ret, $moon);
    }
    
    return $ret;
  }
  
  public static function goToSystem($explorer,$from,$id_system=null){
    global $c;

    if (is_null($id_system)){
      $system_connections = self::getSystemConnections($explorer,$from);
      $ind = rand(0,$c->getMaxConnections()-1);
      $new_known = false;
      if (array_key_exists($ind,$system_connections)){
        $new_system_id = $system_connections[$ind]->get('id');
        if (!$system_connections[$ind]->getKnown()){
          $new_known = true;
        }
      }
      else{
        $new_system = self::generateSystem($explorer,$from);
        $new_system_id = $new_system->get('id');
        $new_known = true;
      }
      if ($new_known){
        //echo "-COMPRUEBO ESC\n";
        $esc = new G_ExplorerSystemConnection();
        if (!$esc->buscar(array(
          'id_explorer' => $explorer->get('id'),
          'id_system_1' => $from->get('id'),
          'id_system_2' => $new_system_id
        ))){
          //echo "-NUEVO ESC\n";
          //echo "-EXPLORER: " . $explorer->get('id') . "\n";
          //echo "-SYSTEM 1: " . $from->get('id') . "\n";
          //echo "-SYSTEM 2: " . $new_system_id . "\n";
          $esc = new G_ExplorerSystemConnection();
          $esc->set('id_explorer', $explorer->get('id'));
          $esc->set('id_system_1', $from->get('id'));
          $esc->set('id_system_2', $new_system_id);
          $esc->salvar();
        }
      }
      $dist = self::goToSystem($explorer,$from,$new_system_id);
    }
    else{
      $sd = new G_SystemDistance();
      $sd->buscar(array(
        'id_system_1' => $from->get('id'),
        'id_system_2' => $id_system
      ));
      $dist = $sd->get('distance');
    }
    return $dist;
  }

  public static function getSystems(){
    $sql = "SELECT * FROM `system`";
    $bd = new G_BBDD();
    $bd->consulta($sql);

    $ret = array();

    while ($res = $bd->sig()) {
      $s = new G_System();
      $s->actualizar($res);

      array_push($ret, $s);
    }

    return $ret;
  }
  
  public static function loadSystemConnections($explorer,$from){
    $ret = array('connection_1'=>false,'connection_2'=>false,'connection_3'=>false);
    $connections = self::getSystemConnections($explorer,$from);
    
    foreach ($connections as $i => $conn){
      $ret['connection_'.($i+1)] = $conn;
    }
    
    return $ret;
  }

  public static function getSystemConnections($explorer,$from){
    $sql = "SELECT * FROM `system_distance` WHERE `id_system_1` = '".$from->get('id')."' AND `distance` = 1";
    $bd = new G_BBDD();
    $bd->consulta($sql);

    $ret = array();

    while ($res = $bd->sig()){
      $sd = new G_SystemDistance();
      $sd->actualizar($res);

      array_push($ret,$sd);
    }

    foreach($ret as $conn){
      $esc = new G_ExplorerSystemConnection();
      if ($esc->buscar(array(
        'id_explorer' => $explorer->get('id'),
        'id_system_1' => $conn->get('id_system_1'),
        'id_system_2' => $conn->get('id_system_2')
      ))){
        $conn->setKnown(true);
      }
    }

    return $ret;
  }
  
  public static function generateSystem($explorer,$from=null){
    global $c;

    // Primero creo el sistema
    $s = new G_System();
    $system_types  = Base::getCache('system');
    $planet_types  = Base::getCache('planet');
    $sun_type      = $system_types['mkk_types'][array_rand($system_types['mkk_types'])];
    $sun_spectral_type = $sun_type['spectral_types'][array_rand($sun_type['spectral_types'])];
    $sun_type_code = $sun_type['type'].'-'.$system_types['spectral_types']['type_'.$sun_spectral_type]['type'];
    $sun_name      = Base::getRandomCharacters(array('num'=>$c->getSystemNameChars(),'upper'=>true)).'-'.Base::getRandomCharacters(array('num'=>$c->getSystemNameNums(),'numbers'=>true));
    $num_planets   = rand($sun_type['min_planets'],$sun_type['max_planets']);

    $s->set('id_discoverer',$explorer->get('id'));
    $s->set('original_name',$sun_name);
    $s->set('name',$sun_name);
    $s->set('num_planets',$num_planets);
    $s->set('sun_type',$sun_type_code);

    //echo "SYSTEM\n";
    //echo "-------------------------------------------------------------------------------------\n";
    //echo "ID DISCOVERER: ".$explorer->get('id')."\n";
    //echo "ORIGINAL NAME: ".$sun_name."\n";
    //echo "NAME: ".$sun_name."\n";
    //echo "NUM PLANETS: ".$num_planets."\n";
    //echo "SUN TYPE: ".$sun_type_code."\n";
    //echo "-------------------------------------------------------------------------------------\n\n";
    
    $s->salvar();

    // NPCs en el sistema
    $npcs = 0;

    // Distancias a las que hay planetas, para que no choquen
    $planet_distances = array();

    // Creo los planetas del sistema
    for ($i=1;$i<=$num_planets;$i++){
      $p = new G_Planet();

      $planet_name = $sun_name.'-'.$i;

      $p->set('id_system',$s->get('id'));
      $p->set('id_owner',null);
      $p->set('original_name',$planet_name);
      $p->set('name',$planet_name);

      //echo "  PLANET\n";
      //echo "  -------------------------------------------------------------------------------------\n";
      //echo "  ORIGINAL NAME: ".$planet_name."\n";

      $ind = array_rand($sun_type['planet_types']);
      $planet_type_id = $sun_type['planet_types'][$ind];
      $planet_type = $planet_types['planet_types']['type_'.$planet_type_id];
      $planet_radius = rand($planet_type['min_radius'],$planet_type['max_radius']);
      $planet_survival = $planet_type['survival'];
      $planet_has_life = $planet_type['has_life'];
      $num_moons = rand($planet_type['min_moons'],$planet_type['max_moons']);

      //echo "  TYPE: ".$planet_type_id."\n";
      //echo "  RADIUS: ".$planet_radius."\n";
      //echo "  SURVIVAL: ".$planet_survival."\n";
      //echo "  HAS_LIFE: ".($planet_has_life?"Y":"N")."\n";
      //echo "  NUM MOONS: ".$num_moons."\n";

      $p->set('id_type',$planet_type_id);
      $p->set('radius',$planet_radius);
      $p->set('survival',$planet_survival);
      $p->set('has_life',$planet_has_life);
      $p->set('num_moons',$num_moons);

      $planet_distance = rand($planet_type['min_distance'],$planet_type['max_distance']);
      while (in_array($planet_distance,$planet_distances)){
        $planet_distance = rand($planet_type['min_distance'],$planet_type['max_distance']);
      }
      array_push($planet_distances,$planet_distance);
      $p->set('distance',$planet_distance);

      //echo "  DISTANCE: ".$planet_distance."\n";
      //echo "  -------------------------------------------------------------------------------------\n\n";

      // NPC
      $planet_has_npc = false;
      if ($npcs<$c->getMaxNPC()){
        $npc_prob = rand(1,$c->getNPCProb());
        if ($npc_prob==1){
          $npc = NPC::generateNPC();
          $p->set('id_owner',$npc->get('id'));
          $p->set('npc',true);
          $npcs++;
          $planet_has_npc = true;
        }
      }

      $planet_resource_list  = array();
      if (!$planet_has_npc){
        // Resources
        $resource_types = Base::getCache('resource');
        $num_resources  = rand(0,$c->getMaxSellResources());
        if ($num_resources>0) {
          while (count($planet_resource_list) < $num_resources) {
            $resource = $resource_types['resources'][array_rand($resource_types['resources'])];
            if (!array_key_exists($resource['id'],$planet_resource_list)){
              $planet_resource_list[$resource['id']] = rand($resource['min'], $resource['max']);
            }
          }
        }
      }

      $p->salvar();

      if (count($planet_resource_list)>0){
        foreach ($planet_resource_list as $resource_id=>$value){
          $planet_resource = new G_Resources();
          $planet_resource->set('id_planet',$p->get('id'));
          $planet_resource->set('id_moon',0);
          $planet_resource->set('id_resource_type',$resource_id);
          $planet_resource->set('value',$value);

          $planet_resource->salvar();
        }
      }

      $moon_distances = array();

      // Creo las lunas del planeta
      for ($j=1;$j<=$num_moons;$j++){
        $m = new G_Moon();

        $moon_name = $planet_name.'-L'.$j;

        //echo "    MOON\n";
        //echo "    -------------------------------------------------------------------------------------\n";
        //echo "    ORIGINAL NAME: ".$moon_name."\n";

        $m->set('id_planet',$p->get('id'));
        $m->set('original_name',$moon_name);
        $m->set('name',$moon_name);

        $moon_radius = rand(1000,floor($planet_radius*0.66));
        $m->set('radius',$moon_radius);

        //echo "    RADIUS: ".$moon_radius."\n";

        // Indice de supervivencia es aleatorio entre 1 y el del planeta (+2 si tiene vida)
        $moon_survival = rand(1, $planet_survival + ($planet_has_life?$c->getLifeBonus():0));
        $m->set('survival',$moon_survival);
        
        // 50% de posibilidad de que haya vida si el indice de survival es mayor que 5
        $moon_has_life = ($moon_survival>5)?(rand(1,2)==1):false;
        $m->set('has_life',$moon_has_life);

        //echo "    SURVIVAL: ".$moon_survival."\n";
        //echo "    HAS LIFE: ".($moon_has_life?"Y":"N")."\n";

        $moon_distance = rand(1,$num_moons);
        while (in_array($moon_distance,$moon_distances)){
          $moon_distance = rand(1,$num_moons);
        }
        array_push($moon_distances,$moon_distance);
        $m->set('distance',$moon_distance);
        //echo "    DISTANCE: ".$moon_distance."\n";

        $moon_has_npc = false;
        if ($npcs<$c->getMaxNPC()){
          $npc_prob = rand(1,$c->getNPCProb());
          if ($npc_prob==1){
            $npc = NPC::generateNPC();
            $m->set('id_owner',$npc->get('id'));
            $m->set('npc',true);
            $npcs++;
            $moon_has_npc = true;
          }
        }

        $moon_resource_list  = array();
        if (!$moon_has_npc){
          // Resources
          $resource_types = Base::getCache('resource');
          $num_resources  = rand(0,$c->getMaxSellResources());
          if ($num_resources>0) {
            while (count($moon_resource_list) < $num_resources) {
              $resource = $resource_types['resources'][array_rand($resource_types['resources'])];
              if (!array_key_exists($resource['id'],$moon_resource_list)){
                $moon_resource_list[$resource['id']] = rand($resource['min'], $resource['max']);
              }
            }
          }
        }

        //echo "    -------------------------------------------------------------------------------------\n\n";

        $m->salvar();

        if (count($moon_resource_list)>0){
          foreach ($moon_resource_list as $resource_id=>$value){
            $planet_resource = new G_Resources();
            $planet_resource->set('id_planet',0);
            $planet_resource->set('id_moon',$m->get('id'));
            $planet_resource->set('id_resource_type',$resource_id);
            $planet_resource->set('value',$value);

            $planet_resource->salvar();
          }
        }
      }
    }

    if ($npcs>0) {
      $s->set('num_npc',$npcs);
      $s->salvar();
    }

    // Calculo distancia entre sistemas
    if (!is_null($from)){
      //echo "CALCULO DISTANCIAS ENTRE SISTEMAS\n";
      $system_list = self::getSystems();
      //echo "HAY ".count($system_list)." SISTEMAS\n";
      //echo "FROM: ".$from->get('id')."\n";
      //echo "S: ".$s->get('id')."\n";
      foreach ($system_list as $system) {
        //echo "--------------------------------------------------------------------\n";
        //echo "SYSTEM: ".$system->get('id')."\n";
        if ($system->get('id') == $s->get('id')) {
          //echo "SYSTEM==S, CONTINUA\n";
          //echo "--------------------------------------------------------------------\n\n";
          continue;
        }
        if ($system->get('id') != $from->get('id')) {
          //echo "SYSTEM != FROM\n";
          $sd_aux = new G_SystemDistance();
          $res = $sd_aux->buscar(array(
            'id_system_1' => $system->get('id'),
            'id_system_2' => $from->get('id')
          ));
          if($res===false){
            //echo "NO HAY CONEXION ".$system->get('id')."-".$from->get('id')." BUSCO AL REVES\n";
            $res = $sd_aux->buscar(array(
              'id_system_1' => $from->get('id'),
              'id_system_2' => $system->get('id')
            ));
          }
          $dist = $sd_aux->get('distance');
          //echo "DISTANCIA SYSTEM( ".$system->get('id')." ) - FROM( ".$from->get('id')." ) : ".$dist."\n";
        } else {
          //echo "SYSTEM == FROM, DIST: 0\n";
          $dist = 0;
        }

        //echo "NUEVO SD\n";
        //echo "SYSTEM 1: ".$system->get('id')."\n";
        //echo "SYSTEM 2: ".$s->get('id')."\n";
        //echo "DISTANCE: ".($dist + 1)."\n";
        $sd = new G_SystemDistance();
        $sd->set('id_system_1', $system->get('id'));
        $sd->set('id_system_2', $s->get('id'));
        $sd->set('distance', $dist + 1);
        $sd->salvar();

        //echo "COMPRUEBO ESC\n";
        $esc = new G_ExplorerSystemConnection();
        if (!$esc->buscar(array(
          'id_explorer' => $explorer->get('id'),
          'id_system_1' => $system->get('id'),
          'id_system_2' => $s->get('id')
        ))){
          //echo "NUEVO ESC\n";
          //echo "EXPLORER: " . $explorer->get('id') . "\n";
          //echo "SYSTEM 1: " . $system->get('id') . "\n";
          //echo "SYSTEM 2: " . $s->get('id') . "\n";
          $esc = new G_ExplorerSystemConnection();
          $esc->set('id_explorer', $explorer->get('id'));
          $esc->set('id_system_1', $system->get('id'));
          $esc->set('id_system_2', $s->get('id'));
          $esc->salvar();
        }
        //echo "--------------------------------------------------------------------\n\n";
      }
    }

    return $s;
  }
}