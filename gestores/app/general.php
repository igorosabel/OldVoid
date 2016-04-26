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
    $system_types = Base::getCache('system');
    $type         = $system_types['system_types'][array_rand($system_types['system_types'])];
    $s_name       = Base::getRandomCharacters(array('num'=>3,'upper'=>true)).'-'.Base::getRandomCharacters(array('num'=>3,'numbers'=>true));
    $num_planets  = rand($type['min_planets'],$type['max_planets']);

    $s->set('id_discoverer',$explorer->get('id'));
    $s->set('original_name',$s_name);
    $s->set('name',$s_name);
    $s->set('num_planets',$num_planets);
    $s->set('sun_id_type',$type['id']);

    $s->salvar();

    // Creo los planetas del sistema
    for ($i=1;$i<=$num_planets;$i++){
      $p = new G_Planet();

      $p_name = $s_name.'-'.$i;

      $p->set('id_system',$s->get('id'));
      $p->set('id_owner',null);
      $p->set('original_name',$p_name);
      $p->set('name',$p_name);

      $p->salvar();

      // Creo las lunas del planeta

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