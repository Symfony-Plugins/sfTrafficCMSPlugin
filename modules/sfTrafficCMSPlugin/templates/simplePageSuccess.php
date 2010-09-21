<h1><?php echo $page->title ?></h1>
<?php include_partial('sfTrafficCMSPlugin/subPageMenu', array('page' => $page, 'currentPage' => $page)) ?>
<?php if ($page->hasRelation('Images')): ?>
<?php foreach ($page->getImages() as $image): ?>
<?php if ($image->hasImageSrc()): ?>
  <img src="<?php echo $image->getImageSrc() ?>" />
<?php endif ?>
<?php endforeach ?>
<?php endif ?>
<div id="body"><?php echo $sf_data->getRaw('page')->body_copy ?></div>
