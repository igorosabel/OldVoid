<?php
class stShip{
  const MODULE_SMALL = 0;
  const MODULE_BIG   = 1;
  const MODULE_STORAGE      = 'storage';
  const MODULE_STORAGE_NAME = 'Almacenamiento';

  public static function loadShip($explorer){
    $ship = new Ship();
    if ($ship->find(array('id'=>$explorer->get('current_ship')))){
      $ship->setGuns(         self::loadGuns($ship));
      $ship->setModulesSmall( self::loadModules($ship,self::MODULE_SMALL));
      $ship->setModulesBig(   self::loadModules($ship,self::MODULE_BIG));
    }

    return $ship;
  }

  public static function loadGuns($ship){
    $db = new ODB();
    $ret = array();
    
    $sql = "SELECT * FROM `gun` WHERE `id_ship` = ".$ship->get('id');
    $db->query($sql);
    
    while ($res=$db->next()){
      $gun = new Gun();
      $gun->update($res);
      
      array_push($ret,$gun);
    }
    
    return $ret;
  }
  
  public static function loadModules($ship,$size=null){
    $db = new ODB();
    $ret = array();
    
    $sql = "SELECT * FROM `module` WHERE `id_ship` = ".$ship->get('id');
    if (!is_null($size)){
      $sql .= " AND `size` = ".$size;
    }
    $db->query($sql);
    
    while ($res=$db->next()){
      $module = new Module();
      $module->update($res);
      
      array_push($ret,$module);
    }
    
    return $ret;
  }

  public static function getHullTypeName($id){
    $hulls = Base::getCache('hull');
    if (array_key_exists('hull_'.$id,$hulls['hull_types'])){
      return $hulls['hull_types']['hull_'.$id]['name'];
    }
    return '';
  }

  public static function getShieldTypeName($id){
    $shields = Base::getCache('shield');
    if (array_key_exists('shield_'.$id,$shields['shield_types'])){
      return $shields['shield_types']['shield_'.$id]['name'];
    }
    return '';
  }

  public static function getEngineTypeName($id){
    $engines = Base::getCache('engine');
    if (array_key_exists('engine_'.$id,$engines['engine_types'])){
      return $engines['engine_types']['engine_'.$id]['name'];
    }
    return '';
  }

  public static function getGeneratorTypeName($id){
    $generators = Base::getCache('generator');
    if (array_key_exists('generator_'.$id,$generators['generator_types'])){
      return $generators['generator_types']['generator_'.$id]['name'];
    }
    return '';
  }

  public static function getGunTypeName($id){
    $guns = Base::getCache('gun');
    if (array_key_exists('gun_'.$id,$guns['gun_types'])){
      return $guns['gun_types']['gun_'.$id]['name'];
    }
    return '';
  }

  public static function getModuleTypeName($id){
    $modules = Base::getCache('module');
    if (array_key_exists('module_'.$id,$modules['module_types'])){
      return $modules['module_types']['module_'.$id]['name'];
    }
    return '';
  }

  public static function getModuleEnableName($id){
    switch($id){
      case self::MODULE_STORAGE: {
        return self::MODULE_STORAGE_NAME;
      }
    }
    return '';
  }
  
  public static function generateShip($explorer){
    global $c;

    // Primero creo la nave, sin armas ni módulos
    $ship = new Ship();
    $ship->set('id_owner',$explorer->get('id'));

    $ship_name = Base::getRandomCharacters(array('num'=>$c->getExtra('system_name_chars'),'upper'=>true)).'-'.Base::getRandomCharacters(array('num'=>$c->getExtra('system_name_nums'),'numbers'=>true));
    $ship->set('original_name',$ship_name);
    $ship->set('name',$ship_name);

    $hull_types = Base::getCache('hull');
    $hull_type  = $hull_types['hull_types']['hull_'.$c->getExtra('default_ship_hull')];
    $ship->set('hull_id_type',          $hull_type['id']);
    $ship->set('hull_strength',         $hull_type['strength']);
    $ship->set('hull_current_strength', $hull_type['strength']);
    $ship->set('hull_mass',             $hull_type['mass']);
    $ship->set('gun_ports',             $hull_type['gun_ports']);
    $ship->set('big_module_ports',      $hull_type['big_module_ports']);
    $ship->set('small_module_ports',    $hull_type['small_module_ports']);

    $shield_types = Base::getCache('shield');
    $shield_type  = $shield_types['shield_types']['shield_'.$c->getExtra('default_ship_shield')];
    $ship->set('shield_id_type',          $shield_type['id']);
    $ship->set('shield_strength',         $shield_type['strength']);
    $ship->set('shield_current_strength', $shield_type['strength']);
    $ship->set('shield_energy',           $shield_type['energy']);

    $engine_types = Base::getCache('engine');
    $engine_type  = $engine_types['engine_types']['engine_'.$c->getExtra('default_ship_engine')];
    $ship->set('engine_id_type',     $engine_type['id']);
    $ship->set('engine_power',       $engine_type['power']);
    $ship->set('engine_energy',      $engine_type['energy']);
    $ship->set('engine_impulse',     $engine_type['impulse']);
    $ship->set('engine_fuel_cost',   $engine_type['consumption']);
    $ship->set('engine_fuel_actual', 100);

    $generator_types = Base::getCache('generator');
    $generator_type  = $generator_types['generator_types']['generator_'.$c->getExtra('default_ship_generator')];
    $ship->set('generator_id_type', $generator_type['id']);
    $ship->set('generator_power',   $generator_type['power']);

    $ship->save();

    // Creo un arma
    $gun = new Gun();

    $gun_types = Base::getCache('gun');
    $gun_type  = $gun_types['gun_types']['gun_'.$c->getExtra('default_gun')];
    $gun->set('id_type',         $gun_type['id']);
    $gun->set('id_owner',        $explorer->get('id'));
    $gun->set('id_ship',         $ship->get('id'));
    $gun->set('strength',        $gun_type['strength']);
    $gun->set('accuracy',        $gun_type['accuracy']);
    $gun->set('recharge_time',   $gun_type['recharge_time']);
    $gun->set('ignores_shields', $gun_type['ignores_shields']);
    $gun->set('energy',          $gun_type['energy']);
    $gun->set('credits',         $gun_type['credits']);

    $gun->save();
    $ship->addGun($gun);

    // Creo un módulo
    $default_modules = $c->getExtra('default_modules');
    foreach ($default_modules as $module_type){
      $module = new Module();
  
      $module_types = Base::getCache('module');
      $module_type  = $module_types['module_types']['module_'.$module_type];
      $module->set('id_type',          $gun_type['id']);
      $module->set('id_owner',         $explorer->get('id'));
      $module->set('id_ship',          $ship->get('id'));
      $module->set('size',             $module_type['size']);
      $module->set('enables',          $module_type['enables']);
      $module->set('crew',             $module_type['crew']);
      $module->set('mass',             $module_type['mass']);
      $module->set('storage_capacity', $module_type['storage']);
      if ($module_type['enables']=='storage'){
        $module->set('storage',json_encode(array('resource_4'=>100)));
      }
      else{
        $module->set('storage',null);
      }
      $module->set('energy',  $module_type['energy']);
      $module->set('credits', $module_type['credits']);
  
      $module->save();
      if ($module->get('size')==self::MODULE_SMALL){
        $ship->addModuleSmall($module);
      }
      else{
        $ship->addModuleSmall($module);
      }
    }

    $ship->set('credits',self::calculateCredits($ship,array($gun),array_merge($ship->getModulesSmall(),$ship->getModulesBig())));
    $ship->save();

    return $ship;
  }

  public static function calculateCredits($ship,$guns,$modules){
    $ret = 0;

    // Calculo precio de la nave (base + mejoras)
    $hull_types          = Base::getCache('hull');
    $hull_type           = $hull_types['hull_types']['hull_'.$ship->get('hull_id_type')];
    $hull_type_diff      = floor( ( ($ship->get('hull_strength')*100) / $hull_type['strength'] ) / 100 );
    $shield_types        = Base::getCache('shield');
    $shield_type         = $shield_types['shield_types']['shield_'.$ship->get('shield_id_type')];
    $shield_type_diff    = floor( ( ($ship->get('shield_strength')*100) / $shield_type['strength'] ) / 100 );
    $engine_types        = Base::getCache('engine');
    $engine_type         = $engine_types['engine_types']['engine_'.$ship->get('engine_id_type')];
    $engine_type_diff    = floor( ( ($ship->get('engine_power')*100) / $engine_type['power'] ) / 100 );
    $generator_types     = Base::getCache('generator');
    $generator_type      = $generator_types['generator_types']['generator_'.$ship->get('generator_id_type')];
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
}