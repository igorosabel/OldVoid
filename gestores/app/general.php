<?php
class General{
  public static function goToSystem($explorer,$from,$id_system=null){
    if (is_null($id_system)){
      $system_connections = self::getSystemConnections($explorer,$from);
      $ind = rand(0,2);
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

  public static function generateSystem($explorer,$from=null){
    // Primero creo el sistema
    $s = new G_System();
    $system_types  = Base::getCache('system');
    $planet_types  = Base::getCache('planet');
    $sun_type      = $system_types['mkk_types'][array_rand($system_types['mkk_types'])];
    $sun_spectral_type = $sun_type['spectral_types'][array_rand($sun_type['spectral_types'])];
    $sun_type_code = $sun_type['type'].'-'.$system_types['spectral_types']['type_'.$sun_spectral_type]['type'];
    $sun_name      = Base::getRandomCharacters(array('num'=>3,'upper'=>true)).'-'.Base::getRandomCharacters(array('num'=>3,'numbers'=>true));
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

      $planet_distance = rand($planet_type['min_distance'],$planet_type['max_distance']);
      while (in_array($planet_distance,$planet_distances)){
        $planet_distance = rand($planet_type['min_distance'],$planet_type['max_distance']);
      }
      array_push($planet_distances,$planet_distance);
      $p->set('distance',$planet_distance);

      //echo "  DISTANCE: ".$planet_distance."\n";
      //echo "  -------------------------------------------------------------------------------------\n\n";

      $p->salvar();

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
        $moon_survival = rand(1, $planet_survival + ($planet_has_life?2:0));
        $m->set('survival',$moon_survival);
        // 50% de posibilidad de que haya vida si el indice de survival es mayor que 5
        $moon_has_life = ($moon_survival>5)?(rand(1,2)==1):false;
        $m->set('has_life',$moon_has_life);

        //echo "    SURVIVAL: ".$moon_survival."\n";
        //echo "    HAS LIFE: ".($moon_has_life?"Y":"N")."\n";

        $moon_distance = rand($planet_type['min_distance'],$planet_type['max_distance']);
        while (in_array($moon_distance,$moon_distances)){
          $moon_distance = rand($planet_type['min_distance'],$planet_type['max_distance']);
        }
        array_push($moon_distances,$moon_distance);
        $m->set('distance',$moon_distance);
        //echo "    DISTANCE: ".$moon_distance."\n";

        //echo "    -------------------------------------------------------------------------------------\n\n";

        $m->salvar();
      }
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