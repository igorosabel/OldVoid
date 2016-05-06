<?php foreach ($values['people_in_system']['npc'] as $i=>$npc): ?>
  {
    "type": "npc",
    "id": <?php echo $npc['npc']->get('id') ?>,
    "name": "<?php echo urlencode($npc['npc']->get('name')) ?>",
    "where": "<?php echo urlencode($npc['where']) ?>"
  }<?php if ($i<count($values['people_in_system']['npc'])-1): ?>,<?php endif ?>
<?php endforeach ?>
<?php if (count($values['people_in_system']['npc'])>0): ?>,<?php endif ?>
<?php foreach ($values['people_in_system']['explorer'] as $i=>$ex): ?>
  {
    "type": "explorer",
    "id": <?php echo $ex['explorer']->get('id') ?>,
    "name": "<?php echo urlencode($ex['explorer']->get('name')) ?>",
    "where": "<?php echo urlencode($ex['where']) ?>"
  }<?php if ($i<count($values['people_in_system']['explorer'])-1): ?>,<?php endif ?>
<?php endforeach ?>