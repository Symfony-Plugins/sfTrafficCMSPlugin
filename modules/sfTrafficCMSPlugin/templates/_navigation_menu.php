<?php if ($sf_user->isAuthenticated()): ?>
  <?php $routes = sfContext::getInstance()->getRouting()->getRoutes(); ?>
  <?php $nav_items = isset($nav_items) ? $sf_data->getRaw('nav_items') : sfConfig::get('app_sf_traffic_cms_plugin_navigation') ?>

  <?php $config = sfConfig::get('app_sf_traffic_cms_plugin_auto_configure') ?>
  <div class="cms_menu">
    <ul>
    <?php foreach ($nav_items as $model => $options): ?>
      <?php $singleton = (isset($config['models'][$model]['singleton']) && $config['models'][$model]['singleton']) ? $config['models'][$model]['singleton'] : false ?>
      <?php
      if(!isset($options['credential']) && isset($options['credentials'])){
        $options['credential'] = $options['credentials'];
      }
      ?>
      <?php if(!isset($options['credential']) || $sf_user->hasCredential($options['credential'])): ?>
      <?php if(isset($routes[$model])): ?>
      <li>
        <?php echo link_to($options['label'], '@' . $model . ($singleton ? '_edit?id=1' : '')); ?>
      <?php else: ?>
      <li>
        <a ><?php echo $options['label'];?></a>
        
      <?php endif; ?>
        <?php
        if(isset($options['sub_nav'])):
          
        
          include_partial('sfTrafficCMSPlugin/sub_nav', array('sub_nav_items' => $options['sub_nav']));
        endif;
        ?>
      </li>
      <?php endif ?>
    <?php endforeach ?>
    <?php if (!isset($no_logout)): ?>
      <li><?php echo link_to('Log out', '@sf_guard_signout') ?></li>
    <?php endif ?>
    </ul>
  </div>
<?php endif; ?>