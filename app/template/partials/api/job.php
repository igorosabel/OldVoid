<?php if ($values['job']===false): ?>false<?php else: ?>
{
  "id": <?php echo $values['job']->get('id') ?>,
  "type": <?php echo $values['job']->get('type') ?>,
  "type_name": "<?php echo urlencode($values['job']->getJobName()) ?>",
  "value": <?php echo $values['job']->get('value') ?>,
  "start": <?php echo $values['job']->get('start') ?>,
  "duration": <?php echo $values['job']->get('duration') ?>
}
<?php endif ?>