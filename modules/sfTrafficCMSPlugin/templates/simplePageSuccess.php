<h1><?php echo $page->title ?></h1>
<?php include_partial('sfTrafficCMSPlugin/subPageMenu', array('page' => $page, 'currentPage' => $page)) ?>
<?php foreach ($page->getImages() as $image): ?>
<img src="<?php echo $image->getImageSrc() ?>" />
<?php endforeach ?>
<div id="body"><?php echo $sf_data->getRaw('page')->body_copy ?></div>
