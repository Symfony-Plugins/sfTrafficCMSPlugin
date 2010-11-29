<h1><?php echo $subPage->title ?></h1>
<?php include_partial('sfTrafficCMSPlugin/subPageMenu', array('page' => $subPage->Parent, 'currentPage' => $subPage)) ?>
<?php foreach ($subPage->getImages() as $image): ?>
<?php if ($image->hasImageSrc()): ?>
  <img src="<?php echo $image->getImageSrc() ?>" />
<?php endif ?>
<?php endforeach ?>
<div id="body"><?php echo $sf_data->getRaw('subPage')->body_copy ?></div>
