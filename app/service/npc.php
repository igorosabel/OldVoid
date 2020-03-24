<?php
class npcService extends OService{
  function __construct($controller=null){
    $this->setController($controller);
  }

  public function loadNPC($id){
    $db = $this->getController()->getDb();
    $npc = false;

    $sql = "SELECT * FROM `npc` WHERE `id` = ?";
    $db->query($sql, [$id]);

    if ($res=$db->next()){
      $npc = new NPC();
      $npc->update($res);
    }

    return $npc;
  }

  public function generateRace(){
    $race_list = OTools::getCache('race');
    $race_prob = [];
    foreach ($race_list['race_list'] as $race){
      for ($i=1;$i<=$race['proportion'];$i++){
        array_push($race_prob,$race['id']);
      }
    }

    $id_race = $race_prob[array_rand($race_prob)];

    return $id_race;
  }

  public function generateNPC($save=true){
    global $core;

    $npc = new NPC();

    $npc_list = OTools::getCache('npc');
    $npc_name = $npc_list['character_list'][array_rand($npc_list['character_list'])];
    $npc->set('name',$npc_name);

    $npc_race = $this->generateRace();
    $npc->set('id_race',$npc_race);

    // Hulls
    $hull_types = OTools::getCache('hull');
    $num_hulls  = rand(0,$core->config->getExtra('max_sell_hulls'));
    $hull_list  = [];
    if ($num_hulls>0){
      while (count($hull_list)<$num_hulls){
        $hull = $hull_types['hull_types'][array_rand($hull_types['hull_types'])];
        if (!in_array($hull['id'], $hull_list)){
          array_push($hull_list, $hull['id']);
        }
      }
    }
    $npc->set('hulls_start', json_encode($hull_list));
    $npc->set('hulls_actual',json_encode($hull_list));

    // Shields
    $shield_types = OTools::getCache('shield');
    $num_shields  = rand(0,$core->config->getExtra('max_sell_shields'));
    $shield_list  = [];
    if ($num_shields>0){
      while (count($shield_list)<$num_shields){
        $shield = $shield_types['shield_types'][array_rand($shield_types['shield_types'])];
        if (!in_array($shield['id'], $shield_list)){
          array_push($shield_list, $shield['id']);
        }
      }
    }
    $npc->set('shields_start', json_encode($shield_list));
    $npc->set('shields_actual',json_encode($shield_list));

    // Engines
    $engine_types = OTools::getCache('engine');
    $num_engines  = rand(0,$core->config->getExtra('max_sell_engines'));
    $engine_list  = [];
    if ($num_engines>0){
      while (count($engine_list)<$num_engines){
        $engine = $engine_types['engine_types'][array_rand($engine_types['engine_types'])];
        if (!in_array($engine['id'], $engine_list)){
          array_push($engine_list, $engine['id']);
        }
      }
    }
    $npc->set('engines_start', json_encode($engine_list));
    $npc->set('engines_actual',json_encode($engine_list));

    // Generators
    $generator_types = OTools::getCache('generator');
    $num_generators  = rand(0,$core->config->getExtra('max_sell_generators'));
    $generator_list  = [];
    if ($num_generators>0){
      while (count($generator_list)<$num_generators){
        $generator = $generator_types['generator_types'][array_rand($generator_types['generator_types'])];
        if (!in_array($generator['id'], $generator_list)){
          array_push($generator_list, $generator['id']);
        }
      }
    }
    $npc->set('generators_start', json_encode($generator_list));
    $npc->set('generators_actual',json_encode($generator_list));

    // Guns
    $gun_types = OTools::getCache('gun');
    $num_guns  = rand(0,$core->config->getExtra('max_sell_guns'));
    $gun_list  = [];
    if ($num_guns>0){
      while (count($gun_list)<$num_guns){
        $gun = $gun_types['gun_types'][array_rand($gun_types['gun_types'])];
        if (!in_array($gun['id'], $gun_list)){
          array_push($gun_list, $gun['id']);
        }
      }
    }
    $npc->set('guns_start', json_encode($gun_list));
    $npc->set('guns_actual',json_encode($gun_list));

    // Modules
    $module_types = OTools::getCache('module');
    $num_modules  = rand(0,$core->config->getExtra('max_sell_modules'));
    $module_list  = [];
    if ($num_modules>0){
      while (count($module_list)<$num_modules){
        $module = $module_types['module_types'][array_rand($module_types['module_types'])];
        if (!in_array($module['id'], $module_list)){
          array_push($module_list, $module['id']);
        }
      }
    }
    $npc->set('modules_start', json_encode($module_list));
    $npc->set('modules_actual',json_encode($module_list));

    // Resources
    $resource_types = OTools::getCache('resource');
    $num_resources  = rand(0,$core->config->getExtra('max_sell_resources'));
    $resource_list  = [];
    if ($num_resources>0){
      while (count($resource_list)<$num_resources){
        $resource = $resource_types['resource_types'][array_rand($resource_types['resource_types'])];
        if (!in_array($resource['id'], $resource_list)){
          array_push($resource_list, $resource['id']);
        }
      }
    }
    $npc->set('resources_start', json_encode($resource_list));
    $npc->set('resources_actual',json_encode($resource_list));

    if ($save) {
      $npc->save();
    }

    return $npc;
  }
}