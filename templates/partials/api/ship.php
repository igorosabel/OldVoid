<?php if ($values['ship']===false): ?>false<?php else: ?>
<?php $s = $values['ship']; ?>
{
  "id": <?php echo $s->get('id') ?>,
  "original_name": "<?php echo urlencode($s->get('original_name')) ?>",
  "name": "<?php echo urlencode($s->get('name')) ?>",
  "hull_id_type": <?php echo $s->get('hull_id_type') ?>,
  "hull_type_name": "<?php echo urlencode(stShip::getHullTypeName($s->get('hull_id_type'))) ?>",
  "hull_strength": <?php echo $s->get('hull_strength') ?>,
  "hull_current_strength": <?php echo $s->get('hull_current_strength') ?>,
  "hull_strength_percent": <?php echo floor(($s->get('hull_current_strength')*100) / $s->get('hull_strength')) ?>,
  "hull_mass": <?php echo $s->get('hull_mass') ?>,
  "gun_ports": <?php echo $s->get('gun_ports') ?>,
  "big_module_ports": <?php echo $s->get('big_module_ports') ?>,
  "small_module_ports": <?php echo $s->get('small_module_ports') ?>,
  "shield_id_type": <?php echo $s->get('shield_id_type') ?>,
  "shield_type_name": "<?php echo urlencode(stShip::getShieldTypeName($s->get('shield_id_type'))) ?>",
  "shield_strength": <?php echo $s->get('shield_strength') ?>,
  "shield_current_strength": <?php echo $s->get('shield_current_strength') ?>,
  "shield_energy": <?php echo $s->get('shield_energy') ?>,
  "engine_id_type": <?php echo $s->get('engine_id_type') ?>,
  "engine_type_name": "<?php echo urlencode(stShip::getEngineTypeName($s->get('engine_id_type'))) ?>",
  "engine_power": <?php echo $s->get('engine_power') ?>,
  "engine_energy": <?php echo $s->get('engine_energy') ?>,
  "engine_impulse": <?php echo $s->get('engine_impulse') ?>,
  "engine_fuel_cost": <?php echo $s->get('engine_fuel_cost') ?>,
  "engine_fuel_actual": <?php echo $s->get('engine_fuel_actual') ?>,
  "generator_id_type": <?php echo $s->get('generator_id_type') ?>,
  "generator_type_name": "<?php echo urlencode(stShip::getGeneratorTypeName($s->get('generator_id_type'))) ?>",
  "generator_power": <?php echo $s->get('generator_power') ?>,
  "credits": <?php echo $s->get('credits') ?>,
  "guns": [
<?php foreach ($s->getGuns() as $i => $gun): ?>
    {
      "id": <?php echo $gun->get('id') ?>,
      "id_type": <?php echo $gun->get('id_type') ?>,
      "gun_type_name": "<?php echo urlencode(stShip::getGunTypeName($gun->get('id_type'))) ?>",
      "strength": <?php echo $gun->get('strength') ?>,
      "accuracy": <?php echo $gun->get('accuracy') ?>,
      "recharge_time": <?php echo $gun->get('recharge_time') ?>,
      "ignores_shields": <?php echo ($gun->get('ignores_shields') ? 'true' : 'false') ?>,
      "energy": <?php echo $gun->get('energy') ?>,
      "credits": <?php echo $gun->get('credits') ?>
    }<?php if ($i<count($s->getGuns())-1): ?>,<?php endif ?>
<?php endforeach ?>
  ],
  "modules_small": [
  <?php foreach ($s->getModulesSmall() as $i => $module): ?>
    {
      "id": <?php echo $module->get('id') ?>,
      "id_type": <?php echo $module->get('id_type') ?>,
      "module_type_name": "<?php echo urlencode(stShip::getModuleTypeName($module->get('id_type'))) ?>",
      "size": <?php echo $module->get('size') ?>,
      "enables": <?php if ($module->get('enables')==''): ?>false<?php else: ?>
      <?php $module_enables = explode(",",$module->get('enables')); ?>
        [
      <?php foreach ($module_enables as $j=>$enable): ?>
          {
            "id": "<?php echo $enable ?>",
            "enable_name": "<?php echo urlencode(stShip::getModuleEnableName($enable)) ?>"
          }<?php if ($j<count($module_enables)-1): ?>,<?php endif ?>
      <?php endforeach ?>
        ]
      <?php endif ?>,
      "crew": <?php echo $module->get('crew') ?>,
      "mass": <?php echo $module->get('mass') ?>,
      "storage_capacity": <?php echo $module->get('storage_capacity') ?>,
    "storage": <?php if ($module->get('storage')==''): ?>false<?php else: ?>
      [
      <?php
        $storage = json_decode($module->get('storage'),true);
        $j = 0;
      ?>
      <?php foreach ($storage as $resource): ?>
        {
        "resource_id": <?php echo $resource['resource_id'] ?>,
        "resource_name": "<?php echo urlencode(stGeneral::getResourceName($resource['resource_id'])) ?>",
        "value": <?php echo $resource['value'] ?>
        }
        <?php $j++ ?>
        <?php if ($j<count($storage)): ?>,<?php endif ?>
      <?php endforeach ?>
      ]
    <?php endif ?>,
      "energy": <?php echo $module->get('energy') ?>,
      "credits": <?php echo $module->get('credits') ?>
    }<?php if ($i<count($s->getModulesSmall())-1): ?>,<?php endif ?>
  <?php endforeach ?>
  ],
  "modules_big": [
  <?php foreach ($s->getModulesBig() as $i => $module): ?>
    {
    "id": <?php echo $module->get('id') ?>,
    "id_type": <?php echo $module->get('id_type') ?>,
    "module_type_name": "<?php echo urlencode(stShip::getModuleTypeName($module->get('id_type'))) ?>",
    "size": <?php echo $module->get('size') ?>,
    "enables": <?php if ($module->get('enables')==''): ?>false<?php else: ?>
      <?php $module_enables = explode(",",$module->get('enables')); ?>
      [
      <?php foreach ($module_enables as $j=>$enable): ?>
        {
        "id": "<?php echo $enable ?>",
        "enable_name": "<?php echo urlencode(stShip::getModuleEnableName($enable)) ?>"
        }<?php if ($j<count($module_enables)-1): ?>,<?php endif ?>
      <?php endforeach ?>
      ]
    <?php endif ?>,
    "crew": <?php echo $module->get('crew') ?>,
    "mass": <?php echo $module->get('mass') ?>,
    "storage_capacity": <?php echo $module->get('storage_capacity') ?>,
    "storage": <?php if ($module->get('storage')==''): ?>false<?php else: ?>
      [
      <?php $storage = json_decode($module->get('storage'),true); ?>
      <?php foreach ($storage as $j=>$resource): ?>
        {
        "resource_id": <?php echo $resource['resource_id'] ?>,
        "resource_name": "<?php echo urlencode(stGeneral::getResourceName($resource['resource_id'])) ?>",
        "value": <?php echo $resource['value'] ?>
        }<?php if ($j<count($storage)-1): ?>,<?php endif ?>
      <?php endforeach ?>
      ]
    <?php endif ?>,
    "energy": <?php echo $module->get('energy') ?>,
    "credits": <?php echo $module->get('credits') ?>
    }<?php if ($i<count($s->getModulesBig())-1): ?>,<?php endif ?>
  <?php endforeach ?>
  ]
}
<?php endif ?>