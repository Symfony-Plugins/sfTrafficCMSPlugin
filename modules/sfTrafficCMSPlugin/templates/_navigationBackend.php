<ul>
<?php foreach ($models as $model): ?>
  <li id=""><?php echo $model?> <?php echo link_to('edit', '@' . strtolower(preg_replace('/([^A-Z])([A-Z])/', "$1_$2", $model))) ?></li>
<?php endforeach ?>
</ul>