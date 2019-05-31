<?php foreach ($values['notifications'] as $i=>$notification): ?>
  {
    "id": <?php echo $notification->get('id') ?>,
    "type": <?php echo $notification->get('type') ?>,
    "value": "<?php echo urlencode($notification->get('value')) ?>"
  }<?php if ($i<count($values['notifications'])-1): ?>,<?php endif ?>
<?php endforeach ?>