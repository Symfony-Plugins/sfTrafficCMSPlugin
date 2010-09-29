<?php if ($sf_user->isAuthenticated()): ?>
  <?php $routes = sfContext::getInstance()->getRouting()->getRoutes(); ?>
  

  <?php $config = sfConfig::get('app_sf_traffic_cms_plugin_auto_configure') ?>
  
    <ul>
    <?php foreach ($sub_nav_items as $model => $options): ?>
      <?php $singleton = (isset($config['models'][$model]['singleton']) && $config['models'][$model]['singleton']) ? $config['models'][$model]['singleton'] : false ?>
      <?php if(!isset($options['credential']) || $sf_user->hasCredential($options['credential'])): ?>
      <?php if(isset($routes[$model])): ?>
      <li>
        <?php echo link_to($options['label'], '@' . $model . ($singleton ? '_edit?id=1' : '')); ?>
      <?php else: ?>
      <li>
        <a class="no-href"><?php echo $options['label'];?></a>
      <?php endif; ?>
        <?php
        if(isset($options['sub_menu'])):
          include_partial('sub_nav', array('options' => $options['sub_menu']));
        endif;
        ?>
      </li>
      <?php endif ?>
    <?php endforeach ?>
    </ul>
<?php endif; ?>