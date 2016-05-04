<?php
class General{
  public static function generateAuth(){
    return substr(sha1('v_'.time().'_v'), 0, 32);
  }

  public static function getExplorersInSystem($id){
    $bd = new G_BBDD();
    $sql = "SELECT COUNT(*) AS `num` FROM `explorer` WHERE `last_save_point` = '".$id."'";
    $bd->consulta($sql);

    if ($res = $bd->sig()){
      return $res['num'];
    }
    else{
      return 0;
    }
  }

  public static function generateShip($explorer){
    global $c;

    // Primero creo la nave, sin armas ni módulos
    $ship = new G_Ship();
    $ship->set('id_owner',$explorer->get('id'));

    $ship_name = Base::getRandomCharacters(array('num'=>$c->getSystemNameChars(),'upper'=>true)).'-'.Base::getRandomCharacters(array('num'=>$c->getSystemNameNums(),'numbers'=>true));
    $ship->set('original_name',$ship_name);
    $ship->set('name',$ship_name);

    $hull_types = Base::getCache('hull');
    $hull_type  = $hull_types['hull_types']['hull_'.$c->getDefaultShipHull()];
    $ship->set('hull_id_type',$hull_type['id']);
    $ship->set('hull_strength',$hull_type['strength']);
    $ship->set('hull_current_strength',$hull_type['strength']);
    $ship->set('hull_mass',$hull_type['mass']);
    $ship->set('gun_ports',$hull_type['gun_ports']);
    $ship->set('big_module_ports',$hull_type['big_module_ports']);
    $ship->set('small_module_ports',$hull_type['small_module_ports']);

    $shield_types = Base::getCache('shield');
    $shield_type  = $shield_types['shield_types']['shield_'.$c->getDefaultShipShield()];
    $ship->set('shield_id_type',$shield_type['id']);
    $ship->set('shield_strength',$shield_type['strength']);
    $ship->set('shield_current_strength',$shield_type['strength']);
    $ship->set('shield_energy',$shield_type['energy']);

    $engine_types = Base::getCache('engine');
    $engine_type  = $engine_types['engine_types']['engine_'.$c->getDefaultShipEngine()];
    $ship->set('engine_id_type',$engine_type['id']);
    $ship->set('engine_power',$engine_type['power']);
    $ship->set('engine_energy',$engine_type['energy']);
    $ship->set('engine_impulse',$engine_type['impulse']);
    $ship->set('engine_fuel_cost',$engine_type['consumption']);
    $ship->set('engine_fuel_actual',100);

    $generator_types = Base::getCache('generator');
    $generator_type  = $generator_types['generator_types']['generator_'.$c->getDefaultShipGenerator()];
    $ship->set('generator_id_type',$generator_type['id']);
    $ship->set('generator_power',$generator_type['power']);

    $ship->salvar();

    // Creo un arma
    $gun = new G_Gun();

    $gun_types = Base::getCache('gun');
    $gun_type  = $gun_types['gun_types']['gun_'.$c->getDefaultGun()];
    $gun->set('id_type',$gun_type['id']);
    $gun->set('id_owner',$explorer->get('id'));
    $gun->set('id_ship',$ship->get('id'));
    $gun->set('strength',$gun_type['strength']);
    $gun->set('accuracy',$gun_type['accuracy']);
    $gun->set('recharge_time',$gun_type['recharge_time']);
    $gun->set('ignores_shields',$gun_type['ignores_shields']);
    $gun->set('energy',$gun_type['energy']);
    $gun->set('credits',$gun_type['credits']);

    $gun->salvar();
    $ship->addGun($gun);

    // Creo un módulo
    $default_modules = $c->getDefaultModules();
    foreach ($default_modules as $module_type){
      $module = new G_Module();
  
      $module_types = Base::getCache('module');
      $module_type  = $module_types['module_types']['module_'.$module_type];
      $module->set('id_type',$gun_type['id']);
      $module->set('id_owner',$explorer->get('id'));
      $module->set('id_ship',$ship->get('id'));
      $module->set('size',$module_type['size']);
      $module->set('enables',$module_type['enables']);
      $module->set('crew',$module_type['crew']);
      $module->set('mass',$module_type['mass']);
      $module->set('storage_capacity',$module_type['storage']);
      if ($module_type['enables']=='storage'){
        $module->set('storage',json_encode(array('resource_4'=>100)));
      }
      else{
        $module->set('storage',null);
      }
      $module->set('energy',$module_type['energy']);
      $module->set('credits',$module_type['credits']);
  
      $module->salvar();
      $ship->addModule($module);
    }

    $ship->set('credits',self::calculateCredits($ship,array($gun),array($module)));
    $ship->salvar();

    return $ship;
  }

  public static function calculateCredits($ship,$guns,$modules){
    $ret = 0;

    // Calculo precio de la nave (base + mejoras)
    $hull_types = Base::getCache('hull');
    $hull_type  = $hull_types['hull_types']['hull_'.$ship->get('hull_id_type')];
    $hull_type_diff = floor( ( ($ship->get('hull_strength')*100) / $hull_type['strength'] ) / 100 );
    $shield_types = Base::getCache('shield');
    $shield_type  = $shield_types['shield_types']['shield_'.$ship->get('shield_id_type')];
    $shield_type_diff = floor( ( ($ship->get('shield_strength')*100) / $shield_type['strength'] ) / 100 );
    $engine_types = Base::getCache('engine');
    $engine_type  = $engine_types['engine_types']['engine_'.$ship->get('engine_id_type')];
    $engine_type_diff = floor( ( ($ship->get('engine_power')*100) / $engine_type['power'] ) / 100 );
    $generator_types = Base::getCache('generator');
    $generator_type  = $generator_types['generator_types']['generator_'.$ship->get('generator_id_type')];
    $generator_type_diff = floor( ( ($ship->get('generator_power')*100) / $generator_type['power'] ) / 100 );

    //echo "hull_type credits: ".$hull_type['credits']."\n";
    //echo "hull_type diff: ".$hull_type_diff."\n";
    //echo "shield_type credits: ".$shield_type['credits']."\n";
    //echo "shield_type diff: ".$shield_type_diff."\n";
    //echo "engine_type credits: ".$engine_type['credits']."\n";
    //echo "engine_type diff: ".$engine_type_diff."\n";
    //echo "generator_type credits: ".$generator_type['credits']."\n";
    //echo "generator_type diff: ".$generator_type_diff."\n";

    $ret = ($hull_type['credits'] * $hull_type_diff) + ($shield_type['credits'] * $shield_type_diff) + ($engine_type['credits'] * $engine_type_diff) + ($generator_type['credits'] * $generator_type_diff);

    // Sumo precio de las armas que tiene equipadas
    $gun_types = Base::getCache('gun');
    foreach ($guns as $g){
      $gun_type = $gun_types['gun_types']['gun_'.$g->get('id_type')];
      $ret += $gun_type['credits'];
      //echo "gun_type (".$gun_type['id'].") credits: ".$gun_type['credits']."\n";
    }

    // Sumo precio de los módulos que tiene equipados
    $module_types = Base::getCache('module');
    foreach ($modules as $m){
      $module_type = $module_types['module_types']['module_'.$m->get('id_type')];
      $ret += $module_type['credits'];
      //echo "module_type (".$module_type['id'].") credits: ".$module_type['credits']."\n";
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

  public static function generateRace(){
    $race_list = Base::getCache('race');
    $race_prob = array();
    foreach ($race_list['race_list'] as $race){
      for ($i=1;$i<=$race['proportion'];$i++){
        array_push($race_prob,$race['id']);
      }
    }

    $id_race = $race_prob[array_rand($race_prob)];

    return $id_race;
  }

  public static function generateNPC($save=true){
    global $c;

    $npc = new G_NPC();

    $npc_list = Base::getCache('npc');
    $npc_name = $npc_list['character_list'][array_rand($npc_list['character_list'])];
    $npc->set('name',$npc_name);

    $npc_race = self::generateRace();
    $npc->set('id_race',$npc_race);

    // Hulls
    $hull_types = Base::getCache('hull');
    $num_hulls  = rand(0,$c->getMaxSellHulls());
    $hull_list  = array();
    if ($num_hulls>0){
      while (count($hull_list)<$num_hulls){
        $hull = $hull_types['hull_types'][array_rand($hull_types['hull_types'])];
        if (!in_array($hull['id'], $hull_list)){
          array_push($hull_list, $hull['id']);
        }
      }
    }
    $npc->set('hulls_start',json_encode($hull_list));
    $npc->set('hulls_actual',json_encode($hull_list));

    // Shields
    $shield_types = Base::getCache('shield');
    $num_shields  = rand(0,$c->getMaxSellShields());
    $shield_list  = array();
    if ($num_shields>0){
      while (count($shield_list)<$num_shields){
        $shield = $shield_types['shield_types'][array_rand($shield_types['shield_types'])];
        if (!in_array($shield['id'], $shield_list)){
          array_push($shield_list, $shield['id']);
        }
      }
    }
    $npc->set('shields_start',json_encode($shield_list));
    $npc->set('shields_actual',json_encode($shield_list));

    // Engines
    $engine_types = Base::getCache('engine');
    $num_engines  = rand(0,$c->getMaxSellEngines());
    $engine_list  = array();
    if ($num_engines>0){
      while (count($engine_list)<$num_engines){
        $engine = $engine_types['engine_types'][array_rand($engine_types['engine_types'])];
        if (!in_array($engine['id'], $engine_list)){
          array_push($engine_list, $engine['id']);
        }
      }
    }
    $npc->set('engines_start',json_encode($engine_list));
    $npc->set('engines_actual',json_encode($engine_list));

    // Generators
    $generator_types = Base::getCache('generator');
    $num_generators  = rand(0,$c->getMaxSellGenerators());
    $generator_list  = array();
    if ($num_generators>0){
      while (count($generator_list)<$num_generators){
        $generator = $generator_types['generator_types'][array_rand($generator_types['generator_types'])];
        if (!in_array($generator['id'], $generator_list)){
          array_push($generator_list, $generator['id']);
        }
      }
    }
    $npc->set('generators_start',json_encode($generator_list));
    $npc->set('generators_actual',json_encode($generator_list));

    // Guns
    $gun_types = Base::getCache('gun');
    $num_guns  = rand(0,$c->getMaxSellGuns());
    $gun_list  = array();
    if ($num_guns>0){
      while (count($gun_list)<$num_guns){
        $gun = $gun_types['gun_types'][array_rand($gun_types['gun_types'])];
        if (!in_array($gun['id'], $gun_list)){
          array_push($gun_list, $gun['id']);
        }
      }
    }
    $npc->set('guns_start',json_encode($gun_list));
    $npc->set('guns_actual',json_encode($gun_list));

    // Modules
    $module_types = Base::getCache('module');
    $num_modules  = rand(0,$c->getMaxSellModules());
    $module_list  = array();
    if ($num_modules>0){
      while (count($module_list)<$num_modules){
        $module = $module_types['module_types'][array_rand($module_types['module_types'])];
        if (!in_array($module['id'], $module_list)){
          array_push($module_list, $module['id']);
        }
      }
    }
    $npc->set('modules_start',json_encode($module_list));
    $npc->set('modules_actual',json_encode($module_list));

    // Resources
    $resource_types = Base::getCache('resource');
    $num_resources  = rand(0,$c->getMaxSellResources());
    $resource_list  = array();
    if ($num_resources>0){
      while (count($resource_list)<$num_resources){
        $resource = $resource_types['resource_types'][array_rand($resource_types['resource_types'])];
        if (!in_array($resource['id'], $resource_list)){
          array_push($resource_list, $resource['id']);
        }
      }
    }
    $npc->set('resources_start',json_encode($resource_list));
    $npc->set('resources_actual',json_encode($resource_list));

    if ($save) {
      $npc->salvar();
    }

    return $npc;
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
          $npc = self::generateNPC();
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
            $npc = self::generateNPC();
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