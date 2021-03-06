<?php
class systemService extends OService{
  private $npc_service = null;

  function __construct(){
    $this->loadService();
    $this->npc_service = new npcService();
  }

  public function getSystemColor($type){
    $type_data = explode('-', $type);
    $system = OTools::getCache('system');
    $ret = '#000';
    foreach ($system['spectral_types'] as $stype){
      if ($stype['type']==$type_data[1]){
        $ret = $stype['color'];
        break;
      }
    }

    return $ret;
  }

  public function getSystemTypeName($type){
    $type_data = explode('-', $type);
    $system = OTools::getCache('system');

    foreach ($system['mkk_types'] as $stype){
      if ($stype['type']==$type_data[0]){
        return $stype['name'];
      }
    }

    return '';
  }

  public function getSystemDiscoverer($id_explorer){
    $db = new ODB();
    $sql = "SELECT * FROM `explorer` WHERE `id` = ?";
    $db->query($sql, [$id_explorer]);

    if ($res=$db->next()){
      $explorer = new Explorer();
      $explorer->update($res);

      return $explorer->get('name');
    }
    else{
      return '';
    }
  }

  public function getPlanetTypeName($type){
    $planet_types = OTools::getCache('planet');
    return $planet_types['planet_types']['type_'.$type]['type'];
  }

  public function getExplorersInSystem($explorer,$id_system){
    $db = new ODB();
    $params = [$id_system];
    $sql = "SELECT COUNT(*) AS `num` FROM `explorer` WHERE `last_save_point` = ?";
    if (!is_null($explorer)) {
      $sql .= " AND `id` != ?";
      array_push($params, $explorer->get('id'));
    }
    $db->query($sql, $params);

    if ($res=$db->next()){
      return $res['num'];
    }
    else{
      return 0;
    }
  }

  public function getPeopleInSystem($id){
    $db = new ODB();

    $ret = array('npc'=>[],'explorer'=>[]);

    // NPC en planetas
    $sql = "SELECT a.*, b.`id` AS `planet_id`, b.`name` AS `planet_name` FROM `npc` a, `planet` b WHERE a.`id` = b.`id_owner` AND b.`npc` = 1 AND b.`id_system` = ?";

    $db->query($sql, [$id]);
    while ($res=$db->next()){
      $npc = new NPC();
      $npc->update($res);

      array_push($ret['npc'], [
                                    'npc'        => $npc,
                                    'where_type' => 'planet',
                                    'where_id'   => $res['planet_id'],
                                    'where'      => $res['planet_name']
      ]);
    }

    // NPC en lunas
    $sql = "SELECT a.*, c.`id` AS `moon_id`, c.`name` AS `moon_name` FROM `npc` a, `planet` b, `moon` c WHERE a.`id` = c.`id_owner` AND c.`npc` = 1 AND c.`id_planet` = b.`id` AND b.`id_system` = ?";

    $db->query($sql, [$id]);
    while ($res=$db->next()){
      $npc = new NPC();
      $npc->update($res);

      array_push($ret['npc'], [
                                    'npc'        => $npc,
                                    'where_type' => 'moon',
                                    'where_id'   => $res['moon_id'],
                                    'where'      => $res['moon_name']
      ]);
    }

    // Exploradores en el sistema
    $sql = "SELECT a.*, b.`id` AS `system_id`, b.`name` AS `system_name` FROM `explorer` a, `system` b WHERE a.`last_save_point` = b.`id` AND b.`id` = ?";

    $db->next($sql, [$id]);
    while ($res=$db->next()){
      $ex = new Explorer();
      $ex->update($res);

      array_push($ret['explorer'], [
                                        'explorer'   => $ex,
                                        'where_type' => 'system',
                                        'where_id'   => $res['system_id'],
                                        'where'      => $res['system_name']
      ]);
    }

    return $ret;
  }

  public function loadPlanets($explorer,$system){
    $db = new ODB();
    $ret = [];

    $sql = "SELECT * FROM `planet` WHERE `id_system` = ".$system->get('id')." ORDER BY `distance` ASC";
    $db->query($sql);

    while ($res=$db->next()){
      $planet = new Planet();
      $planet->update($res);

      // Busco NPC en el planeta
      if ($planet->get('npc')){
        $planet->setNpc($this->npc_service->loadNPC($planet->get('id_owner')));
      }

      // Compruebo si el planeta ya ha sido explorado
      $explored = new Explored();
      if ($explored->find([
        'id_explorer' => $explorer->get('id'),
        'id_planet'   => $planet->get('id')
      ])){
        $planet->setExplored(true);
      }

      // Cargo lunas del planeta
      $planet->setMoons($this->loadMoons($explorer,$planet));

      // Cargo recursos del planeta
      $planet->setResources($this->loadResources($planet,'planet'));

      array_push($ret, $planet);
    }

    return $ret;
  }

  public function loadMoons($explorer, $planet){
    $db = new ODB();
    $ret = [];

    $sql = "SELECT * FROM `moon` WHERE `id_planet` = ? ORDER BY `distance` ASC";
    $db->query($sql, [$planet->get('id')]);

    while ($res=$db->next()){
      $moon = new Moon();
      $moon->update($res);

      // Busco NPC en la luna
      if ($moon->get('npc')){
        $moon->setNpc($this->npc_service->loadNPC($moon->get('id_owner')));
      }

      // Compruebo si el planeta ya ha sido explorado
      $explored = new Explored();
      if ($explored->find([
        'id_explorer' => $explorer->get('id'),
        'id_moon'     => $moon->get('id')
      ])){
        $moon->setExplored(true);
      }

      // Cargo recursos de la luna
      $moon->setResources($this->loadResources($moon,'moon'));

      array_push($ret, $moon);
    }

    return $ret;
  }

  public function loadResources($where, $type){
    $db = new ODB();
    $ret = [];

    $sql = "SELECT * FROM `resources` WHERE `id_".$type."` = ?";
    $db->query($sql, [$where->get('id')]);

    while ($res=$db->next()){
      $resource = new Resources();
      $resource->update($res);

      array_push($ret, $resource);
    }

    return $ret;
  }

  public function generateResources($type, $obj){
    $resources = OTools::getCache('resource');
    $id_planet = 0;
    $id_moon   = 0;
    if ($type=='planet'){
      $id_planet = $obj->get('id');
    }
    if ($type=='moon'){
      $id_moon = $obj->get('id');
    }

    $num_resources = rand(0,4);
    $resource_list = [];
    $resource_ids  = [];
    while (count($resource_list)<$num_resources){
      $resource = $resources['resources'][array_rand($resources['resources'])];
      if (!in_array($resource['id'], $resource_ids)){
        array_push($resource_ids, $resource['id']);
        $value = rand($resource['min'], $resource['max']);

        $res = new Resources();
        $res->set('id_planet',        $id_planet);
        $res->set('id_moon',          $id_moon);
        $res->set('id_resource_type', $resource['id']);
        $res->set('value',            $value);
        $res->save();

        array_push($resource_list, $res);
      }
    }

    return $resource_list;
  }

  public function goToSystem($explorer, $from, $id_system=null){
    $ret = null;

    if (is_null($id_system)){
      $system_connections = $this->getSystemConnections($explorer, $from);
      $ind                = rand(0, $this->getConfig()->getExtra('max_connections')-1);
      $new_known          = false;
      if (array_key_exists($ind, $system_connections)){
        $new_system_id = $system_connections[$ind]->get('id');
        if (!$system_connections[$ind]->getKnown()){
          $new_known = true;
        }
      }
      else{
        $new_system    = $this->generateSystem($explorer, $from);
        $new_system_id = $new_system->get('id');
        $new_known     = true;
      }
      if ($new_known){
        //echo "-COMPRUEBO ESC\n";
        $esc = new ExplorerSystemConnection();
        if (!$esc->find([
          'id_explorer' => $explorer->get('id'),
          'id_system_1' => $from->get('id'),
          'id_system_2' => $new_system_id
        ])){
          //echo "-NUEVO ESC\n";
          //echo "-EXPLORER: " . $explorer->get('id') . "\n";
          //echo "-SYSTEM 1: " . $from->get('id') . "\n";
          //echo "-SYSTEM 2: " . $new_system_id . "\n";
          $esc = new ExplorerSystemConnection();
          $esc->set('id_explorer', $explorer->get('id'));
          $esc->set('id_system_1', $from->get('id'));
          $esc->set('id_system_2', $new_system_id);
          $esc->save();
        }
      }
      $ret = $this->goToSystem($explorer, $from, $new_system_id);
    }
    else{
      /*$sd = new G_SystemDistance();
      $sd->buscar([
        'id_system_1' => $from->get('id'),
        'id_system_2' => $id_system
      ]);
      $dist = $sd->get('distance');*/
      $ret = new System();
      $ret->find(['id'=>$id_system]);
    }
    return $ret;
  }

  public function getSystems(){
    $db = new ODB();
    $sql = "SELECT * FROM `system`";
    $db->query($sql);

    $ret = [];

    while ($res=$db->next()) {
      $s = new System();
      $s->update($res);

      array_push($ret, $s);
    }

    return $ret;
  }

  public function loadSystemConnections($explorer,$from){
    $ret = ['connection_1'=>false, 'connection_2'=>false, 'connection_3'=>false];
    $connections = $this->getSystemConnections($explorer, $from);

    foreach ($connections as $i => $conn){
      $ret['connection_'.($i+1)] = $conn;
    }

    return $ret;
  }

  public function getSystemConnections($explorer, $from){
    $db = new ODB();
    $sql = "SELECT * FROM `system_distance` WHERE (`id_system_1` = ? OR `id_system_2` = ?) AND `distance` = 1";
    $db->query($sql, [$from->get('id'), $from->get('id')]);

    $ret = [];

    while ($res = $db->next()){
      $sd = new SystemDistance();
      $sd->update($res);

      array_push($ret,$sd);
    }

    foreach($ret as $conn){
      $esc = new ExplorerSystemConnection();
      if ($esc->find([
        'id_explorer' => $explorer->get('id'),
        'id_system_1' => $conn->get('id_system_1'),
        'id_system_2' => $conn->get('id_system_2')
      ])){
        $conn->setKnown(true);
      }
    }

    return $ret;
  }

  public function generateSystem($explorer, $from=null){
    // Primero creo el sistema
    $s = new System();
    $system_types      = OTools::getCache('system');
    $planet_types      = OTools::getCache('planet');
    $common            = OTools::getCache('common');
    $sun_type          = $system_types['mkk_types'][array_rand($system_types['mkk_types'])];
    $sun_spectral_type = $sun_type['spectral_types'][array_rand($sun_type['spectral_types'])];
    $sun_type_code     = $sun_type['type'].'-'.$system_types['spectral_types']['type_'.$sun_spectral_type]['type'];
    $sun_name          = OTools::getRandomCharacters(['num'=>$this->getConfig()->getExtra('system_name_chars'),'upper'=>true]).'-'.OTools::getRandomCharacters(['num'=>$this->getConfig()->getExtra('system_name_nums'),'numbers'=>true]);
    $num_planets       = rand($sun_type['min_planets'], $sun_type['max_planets']);
    $sun_radius        = rand($sun_type['min_radius'],  $sun_type['max_radius']);

    $s->set('id_discoverer', $explorer->get('id'));
    $s->set('original_name', $sun_name);
    $s->set('name',          $sun_name);
    $s->set('num_planets',   $num_planets);
    $s->set('sun_type',      $sun_type_code);
    $s->set('sun_radius',    $sun_radius);

    //echo "SYSTEM\n";
    //echo "-------------------------------------------------------------------------------------\n";
    //echo "ID DISCOVERER: ".$explorer->get('id')."\n";
    //echo "ORIGINAL NAME: ".$sun_name."\n";
    //echo "NAME: ".$sun_name."\n";
    //echo "NUM PLANETS: ".$num_planets."\n";
    //echo "SUN TYPE: ".$sun_type_code."\n";
    //echo "-------------------------------------------------------------------------------------\n\n";

    $s->save();

    // NPCs en el sistema
    $npcs = 0;

    // Distancias a las que hay planetas, para que no choquen
    $planet_distances = [];

    // Creo los planetas del sistema
    for ($i=1; $i<=$num_planets; $i++){
      $p = new Planet();

      $planet_name = $sun_name.'-'.$i;

      $p->set('id_system',     $s->get('id'));
      $p->set('id_owner',      null);
      $p->set('original_name', $planet_name);
      $p->set('name',          $planet_name);

      //echo "  PLANET\n";
      //echo "  -------------------------------------------------------------------------------------\n";
      //echo "  ORIGINAL NAME: ".$planet_name."\n";

      $ind                 = array_rand($sun_type['planet_types']);
      $planet_type_id      = $sun_type['planet_types'][$ind];
      $planet_type         = $planet_types['planet_types']['type_'.$planet_type_id];
      $planet_radius       = rand($planet_type['min_radius'], $planet_type['max_radius']);
      $planet_rotation     = rand(2, 100);
      $planet_survival     = $planet_type['survival'];
      $planet_has_life     = $planet_type['has_life'];
      $planet_explore_time = rand($common['min_time_explore'], $common['max_time_explore']);
      $num_moons           = rand($planet_type['min_moons'], $planet_type['max_moons']);

      //echo "  TYPE: ".$planet_type_id."\n";
      //echo "  RADIUS: ".$planet_radius."\n";
      //echo "  SURVIVAL: ".$planet_survival."\n";
      //echo "  HAS_LIFE: ".($planet_has_life?"Y":"N")."\n";
      //echo "  NUM MOONS: ".$num_moons."\n";

      $p->set('id_type',      $planet_type_id);
      $p->set('radius',       $planet_radius);
      $p->set('rotation',     $planet_rotation);
      $p->set('survival',     $planet_survival);
      $p->set('has_life',     $planet_has_life);
      $p->set('num_moons',    $num_moons);
      $p->set('explored',     false);
      $p->set('explore_time', $planet_explore_time);

      $planet_distance = rand($planet_type['min_distance'], $planet_type['max_distance']);
      while (in_array($planet_distance, $planet_distances)){
        $planet_distance = rand($planet_type['min_distance'], $planet_type['max_distance']);
      }
      array_push($planet_distances, $planet_distance);
      $p->set('distance', $planet_distance);

      //echo "  DISTANCE: ".$planet_distance."\n";
      //echo "  -------------------------------------------------------------------------------------\n\n";

      // NPC
      $planet_has_npc = false;
      if ($npcs<$this->getConfig()->getExtra('max_npc')){
        $npc_prob = rand(1, $this->getConfig()->getExtra('npc_prob'));
        if ($npc_prob==1){
          $npc = $this->npc_service->generateNPC();
          $p->set('id_owner', $npc->get('id'));
          $p->set('npc',      true);
          $npcs++;
          $planet_has_npc = true;
        }
      }

      $planet_resource_list  = [];
      if (!$planet_has_npc){
        // Resources
        $resource_types = OTools::getCache('resource');
        $num_resources  = rand(0, $this->getConfig()->getExtra('max_sell_resources'));
        if ($num_resources>0) {
          while (count($planet_resource_list) < $num_resources) {
            $resource = $resource_types['resources'][array_rand($resource_types['resources'])];
            if (!array_key_exists($resource['id'], $planet_resource_list)){
              $planet_resource_list[$resource['id']] = rand($resource['min'], $resource['max']);
            }
          }
        }
      }

      $p->save();

      if (count($planet_resource_list)>0){
        foreach ($planet_resource_list as $resource_id=>$value){
          $planet_resource = new Resources();
          $planet_resource->set('id_planet',        $p->get('id'));
          $planet_resource->set('id_moon',          0);
          $planet_resource->set('id_resource_type', $resource_id);
          $planet_resource->set('value',            $value);

          $planet_resource->save();
        }
      }

      $moon_distances = [];

      // Creo las lunas del planeta
      for ($j=1; $j<=$num_moons; $j++){
        $m = new Moon();

        $moon_name = $planet_name.'-L'.$j;

        //echo "    MOON\n";
        //echo "    -------------------------------------------------------------------------------------\n";
        //echo "    ORIGINAL NAME: ".$moon_name."\n";

        $m->set('id_planet',     $p->get('id'));
        $m->set('original_name', $moon_name);
        $m->set('name',          $moon_name);

        $moon_radius = rand(1000, floor($planet_radius*0.66));
        $m->set('radius',        $moon_radius);

        $moon_rotation = rand(2,100);
        $m->set('rotation',      $moon_rotation);

        //echo "    RADIUS: ".$moon_radius."\n";

        // Indice de supervivencia es aleatorio entre 1 y el del planeta (+2 si tiene vida)
        $moon_survival = rand(1, $planet_survival + ($planet_has_life ? $this->getConfig()->getExtra('life_bonus') : 0));
        $m->set('survival',      $moon_survival);

        // 50% de posibilidad de que haya vida si el indice de survival es mayor que 5
        $moon_has_life = ($moon_survival>5) ? (rand(1,2)==1) : false;
        $m->set('has_life',      $moon_has_life);

        //echo "    SURVIVAL: ".$moon_survival."\n";
        //echo "    HAS LIFE: ".($moon_has_life?"Y":"N")."\n";

        $moon_distance = rand(1, $num_moons);
        while (in_array($moon_distance, $moon_distances)){
          $moon_distance = rand(1, $num_moons);
        }
        array_push($moon_distances, $moon_distance);
        $m->set('distance',     $moon_distance);
        //echo "    DISTANCE: ".$moon_distance."\n";

        $moon_explore_time = rand($common['min_time_explore'], $common['max_time_explore']);
        $m->set('explored',     false);
        $m->set('explore_time', $moon_explore_time);

        $moon_has_npc = false;
        if ($npcs<$this->getConfig()->getExtra('max_npc')){
          $npc_prob = rand(1,$this->getConfig()->getExtra('npc_prob'));
          if ($npc_prob==1){
            $npc = $this->npc_service->generateNPC();
            $m->set('id_owner', $npc->get('id'));
            $m->set('npc',      true);
            $npcs++;
            $moon_has_npc = true;
          }
        }

        $moon_resource_list  = [];
        if (!$moon_has_npc){
          // Resources
          $resource_types = OTools::getCache('resource');
          $num_resources  = rand(0, $this->getConfig()->getExtra('max_sell_resources'));
          if ($num_resources>0) {
            while (count($moon_resource_list) < $num_resources) {
              $resource = $resource_types['resources'][array_rand($resource_types['resources'])];
              if (!array_key_exists($resource['id'], $moon_resource_list)){
                $moon_resource_list[$resource['id']] = rand($resource['min'], $resource['max']);
              }
            }
          }
        }

        //echo "    -------------------------------------------------------------------------------------\n\n";

        $m->save();

        if (count($moon_resource_list)>0){
          foreach ($moon_resource_list as $resource_id=>$value){
            $planet_resource = new Resources();
            $planet_resource->set('id_planet',        0);
            $planet_resource->set('id_moon',          $m->get('id'));
            $planet_resource->set('id_resource_type', $resource_id);
            $planet_resource->set('value',            $value);

            $planet_resource->save();
          }
        }
      }
    }

    if ($npcs>0) {
      $s->set('num_npc', $npcs);
      $s->save();
    }

    // Calculo distancia entre sistemas
    if (!is_null($from)){
      //echo "CALCULO DISTANCIAS ENTRE SISTEMAS\n";
      $system_list = $this->getSystems();
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
          $sd_aux = new SystemDistance();
          $res = $sd_aux->find([
            'id_system_1' => $system->get('id'),
            'id_system_2' => $from->get('id')
          ]);
          if($res===false){
            //echo "NO HAY CONEXION ".$system->get('id')."-".$from->get('id')." BUSCO AL REVES\n";
            $res = $sd_aux->find([
              'id_system_1' => $from->get('id'),
              'id_system_2' => $system->get('id')
            ]);
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
        $sd = new SystemDistance();
        $sd->set('id_system_1', $system->get('id'));
        $sd->set('id_system_2', $s->get('id'));
        $sd->set('distance',    $dist + 1);
        $sd->save();

        //echo "COMPRUEBO ESC\n";
        $esc = new ExplorerSystemConnection();
        if (!$esc->find([
          'id_explorer' => $explorer->get('id'),
          'id_system_1' => $system->get('id'),
          'id_system_2' => $s->get('id')
        ])){
          //echo "NUEVO ESC\n";
          //echo "EXPLORER: " . $explorer->get('id') . "\n";
          //echo "SYSTEM 1: " . $system->get('id') . "\n";
          //echo "SYSTEM 2: " . $s->get('id') . "\n";
          $esc = new ExplorerSystemConnection();
          $esc->set('id_explorer', $explorer->get('id'));
          $esc->set('id_system_1', $system->get('id'));
          $esc->set('id_system_2', $s->get('id'));
          $esc->save();
        }
        //echo "--------------------------------------------------------------------\n\n";
      }
    }

    return $s;
  }
}