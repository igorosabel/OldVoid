<?php if ($values['job']===false): ?>false<?php else: ?>
{
  "id": <?php echo $values['job']->get('id') ?>,
  "type": <?php echo $values['job']->get('type') ?>,
  "value": <?php echo $values['job']->get('value') ?>,
  "start": <?php echo $values['job']->get('start') ?>,
  "duration": <?php echo $values['job']->get('duration') ?>
}
<?php endif ?>