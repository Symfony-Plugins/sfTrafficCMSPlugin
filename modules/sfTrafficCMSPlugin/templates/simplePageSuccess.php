<h1><?php echo $page->title ?></h1>
<?php include_partial('sfTrafficCMSPlugin/subPageMenu', array('page' => $page, 'currentPage' => $page)) ?>
<div id="body"><?php echo $sf_data->getRaw('page')->body_copy ?></div>