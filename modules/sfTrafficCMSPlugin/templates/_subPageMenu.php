<?php if ($subPages = $page->getSubPages()): ?>
<ul id="page-sub-menu">
  <li<? if ($sf_data->getRaw('currentPage') instanceof sfTrafficCMSPage) { echo ' class="selected"'; } ?>><a href="<?php echo url_for('@simple_page?slug=' . $page->slug) ?>"><?php echo $page->title ?></a></li>
<?php foreach ($subPages as $subPage): ?>
  <li<? if ($sf_data->getRaw('currentPage') instanceof sfTrafficCMSSubPage && $subPage->id == $currentPage->id) { echo ' class="selected"'; } ?>><a href="<?php echo url_for('@simple_sub_page?slug=' . $subPage->slug . '&parentslug=' . $subPage->Parent->slug) ?>"><?php echo $subPage->title ?></a></li>
<?php endforeach ?>
</ul>
<?php endif ?>