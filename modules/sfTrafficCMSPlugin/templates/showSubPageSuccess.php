<h1><?php echo $subPage->title ?></h1>
<?php include_partial('sfTrafficCMSPlugin/subPageMenu', array('page' => $subPage->Parent, 'currentPage' => $subPage)) ?>
<div id="body"><?php echo $sf_data->getRaw('subPage')->body_copy ?></div>