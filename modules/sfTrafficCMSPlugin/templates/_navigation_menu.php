<?php if ($sf_user->isAuthenticated()): ?>
  <div id="menu">
    <ul>
    <?php $nav_items = sfConfig::get('app_sf_traffic_cms_plugin_navigation') ?>
    <?php $config = sfConfig::get('app_sf_traffic_cms_plugin_auto_configure') ?>
    <?php foreach ($nav_items as $model => $options): ?>
      <?php $singleton = (isset($config['models'][$model]['singleton']) && $config['models'][$model]['singleton']) ? $config['models'][$model]['singleton'] : false ?>
      <?php if(!isset($options['credential']) || $sf_user->hasCredential($options['credential'])): ?>
      <li style="float: left; list-style-type: none; margin-right: 10px">
        <?php echo link_to($options['label'], '@' . $model . ($singleton ? '_edit?id=1' : '')) ?>
      </li>
      <?php endif ?>
    <?php endforeach ?>
    </ul>
  </div>
  <br />
<?php endif; ?>