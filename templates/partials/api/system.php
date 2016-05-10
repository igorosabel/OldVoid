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
  "color": "<?php echo urlencode($s['color']) ?>",
  "radius": <?php echo $s['radius'] ?>,
  "planet_list": [
<?php foreach ($s['planet_list'] as $i => $planet): ?>
    {
      "id": <?php echo $planet->get('id') ?>,
      "name": "<?php echo urlencode($planet->get('name')) ?>",
      "id_owner": <?php echo $planet->get('id_owner') ?>,
      "owner": "",
      "id_type": <?php echo $planet->get('id_type') ?>,
      "type": "",
      "radius": <?php echo $planet->get('radius') ?>,
      "survival": <?php echo $planet->get('survival') ?>,
      "has_life": <?php echo ($planet->get('has_life')==1)?'true':'false' ?>,
      "distance": <?php echo $planet->get('distance') ?>,
      "explored": <?php echo ($planet->getExplored())?'true':'false' ?>,
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
<?php foreach ($planet->getMoons() as $j => $moon): ?>
        {
          "id": <?php echo $moon->get('id') ?>,
          "name": "<?php echo urlencode($moon->get('name')) ?>",
          "id_owner": <?php echo $moon->get('id_owner') ?>,
          "owner": "",
          "radius": <?php echo $moon->get('radius') ?>,
          "survival": <?php echo $moon->get('survival') ?>,
          "has_life": <?php echo ($moon->get('has_life')==1)?'true':'false' ?>,
          "distance": <?php echo $moon->get('distance') ?>,
          "explored": <?php echo ($moon->getExplored())?'true':'false' ?>,
          "npc": <?php if (!$moon->get('npc')): ?>false<?php else: ?>
            {
              "id": <? echo $moon->getNPC()->get('id') ?>,
              "id_race": <? echo $moon->getNPC()->get('id_race') ?>,
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
        }<?php if ($j<count($planet->getMoons())-1): ?>,<?php endif ?>
<?php endforeach ?>
      ]
    }<?php if ($i<count($s['planet_list'])-1): ?>,<?php endif ?>
<?php endforeach ?>
  ],
  "connections": [
<?php foreach ($s['connections'] as $key => $conn): ?>
    <?php if ($conn===false): ?>false<?php else: ?>
    <?php $conn->loadSystem2() ?>
      {
        "id": <?php echo $conn->getSystem2()->get('id') ?>,
        "name": "<?php echo urlencode($conn->getSystem2()->get('name')) ?>"
      }
    <?php endif ?>
    <?php if ($key!='connection_3'): ?>,<?php endif ?>
<?php endforeach ?>
  ]
}