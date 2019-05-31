<?php $s = $values['system']; ?>
{
  "id": <?php echo $s['id'] ?>,
  "name": "<?php echo urlencode($s['name']) ?>",
  "id_discoverer": <?php echo $s['id_discoverer'] ?>,
  "discoverer": "<?php echo urlencode($s['discoverer']) ?>",
  "planets": <?php echo $s['planets'] ?>,
  "npc": <?php echo $s['npc'] ?>,
  "explorers": <?php echo $s['explorers'] ?>,
  "type": "<?php echo urlencode($s['type']) ?>",
  "type_name": "<?php echo urlencode($s['type_name']) ?>",
  "color": "<?php echo urlencode($s['color']) ?>",
  "radius": <?php echo $s['radius'] ?>,
  "planet_list": [
<?php foreach ($s['planet_list'] as $planet_ind => $planet): ?>
    {
      "id": <?php echo $planet->get('id') ?>,
      "name": "<?php echo urlencode($planet->get('name')) ?>",
      "id_owner": <?php echo $planet->get('id_owner') ?>,
      "owner": "",
      "type": <?php echo $planet->get('id_type') ?>,
      "type_name": "<?php echo urlencode($values['system_service']->getPlanetTypeName($planet->get('id_type'))) ?>",
      "radius": <?php echo $planet->get('radius') ?>,
      "rotation": <?php echo $planet->get('rotation') ?>,
      "survival": <?php echo $planet->get('survival') ?>,
      "has_life": <?php echo ($planet->get('has_life')==1)?'true':'false' ?>,
      "distance": <?php echo $planet->get('distance') ?>,
      "explored": <?php echo ($planet->getExplored())?'true':'false' ?>,
      "explore_time": <?php echo $planet->get('explore_time') ?>,
      "resources": [
<?php foreach ($planet->getResources() as $resource_ind => $resource): ?>
        {
          "id": <?php echo $resource->get('id_resource_type') ?>,
          "name": "<?php echo urlencode($values['general_service']->getResourceName($resource->get('id_resource_type'))) ?>",
          "value": <?php echo $resource->get('value') ?>
        }<?php if ($resource_ind<count($planet->getResources())-1): ?>,<?php endif ?>
<?php endforeach ?>
      ],
      "npc": <?php if (!$planet->get('npc')): ?>false<?php else: ?>
        {
          "id": <? echo $planet->getNPC()->get('id') ?>,
          "id_race": <? echo $planet->getNPC()->get('id_race') ?>,
          "race": "",
          "hulls": <?php echo $planet->getNPC()->get('hulls_actual') ?>,
          "shields": <?php echo $planet->getNPC()->get('shields_actual') ?>,
          "engines": <?php echo $planet->getNPC()->get('engines_actual') ?>,
          "generators": <?php echo $planet->getNPC()->get('generators_actual') ?>,
          "guns": <?php echo $planet->getNPC()->get('guns_actual') ?>,
          "modules": <?php echo $planet->getNPC()->get('modules_actual') ?>,
          "resources": <?php echo $planet->getNPC()->get('resources_actual') ?>
        }
      <?php endif ?>,
      "moon_list": [
<?php foreach ($planet->getMoons() as $moon_ind => $moon): ?>
        {
          "id": <?php echo $moon->get('id') ?>,
          "name": "<?php echo urlencode($moon->get('name')) ?>",
          "id_owner": <?php echo $moon->get('id_owner') ?>,
          "owner": "",
          "radius": <?php echo $moon->get('radius') ?>,
          "rotation": <?php echo $moon->get('rotation') ?>,
          "survival": <?php echo $moon->get('survival') ?>,
          "has_life": <?php echo ($moon->get('has_life')==1)?'true':'false' ?>,
          "distance": <?php echo $moon->get('distance') ?>,
          "explored": <?php echo ($moon->getExplored())?'true':'false' ?>,
          "explore_time": <?php echo $moon->get('explore_time') ?>,
          "resources": [
<?php foreach ($moon->getResources() as $resource_ind => $resource): ?>
            {
              "id": <?php echo $resource->get('id_resource_type') ?>,
              "name": "<?php echo urlencode($values['general_service']->getResourceName($resource->get('id_resource_type'))) ?>",
              "value": <?php echo $resource->get('value') ?>
            }<?php if ($resource_ind<count($moon->getResources())-1): ?>,<?php endif ?>
<?php endforeach ?>
          ],
          "npc": <?php if (!$moon->get('npc')): ?>false<?php else: ?>
            {
              "id": <?php echo $moon->getNPC()->get('id') ?>,
              "id_race": <?php echo $moon->getNPC()->get('id_race') ?>,
              "name": "<?php echo urlencode($moon->getNPC()->get('name')) ?>",
              "race": "",
              "hulls": <?php echo $moon->getNPC()->get('hulls_actual') ?>,
              "shields": <?php echo $moon->getNPC()->get('shields_actual') ?>,
              "engines": <?php echo $moon->getNPC()->get('engines_actual') ?>,
              "generators": <?php echo $moon->getNPC()->get('generators_actual') ?>,
              "guns": <?php echo $moon->getNPC()->get('guns_actual') ?>,
              "modules": <?php echo $moon->getNPC()->get('modules_actual') ?>,
              "resources": <?php echo $moon->getNPC()->get('resources_actual') ?>
            }
          <?php endif ?>
        }<?php if ($moon_ind<count($planet->getMoons())-1): ?>,<?php endif ?>
<?php endforeach ?>
      ]
    }<?php if ($planet_ind<count($s['planet_list'])-1): ?>,<?php endif ?>
<?php endforeach ?>
  ],
  "connections": [
<?php foreach ($s['connections'] as $key => $conn): ?>
    <?php if ($conn===false): ?>
      {
        "id": null,
        "name": null,
        "time": <?php echo rand(30,300) ?>
      }
    <?php else: ?>
<?php
      $connection = null;
      if ($conn->get('id_system_2')!=$s['id']){
        $conn->loadSystem2();
        $connection = $conn->getSystem2();
      }
      else{
        $conn->loadSystem1();
        $connection = $conn->getSystem1();
      }
?>
      {
        "id": <?php echo $connection->get('id')  ?>,
        "name": "<?php echo urlencode( $connection->get('name') ) ?>",
        "time": <?php echo rand(30,300) ?>
      }
    <?php endif ?>
    <?php if ($key!='connection_3'): ?>,<?php endif ?>
<?php endforeach ?>
  ]
}