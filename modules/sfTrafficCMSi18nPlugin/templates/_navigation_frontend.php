<!-- needs some attention module and route are generic to avoid errors -->
<?php

$currentModule = $sf_request->getParameter('module');
$config = sfConfig::get('app_sf_traffic_cms_navigation');

if ($config === null || !isset($config['items']))
{
  if (sfContext::getInstance()->getConfiguration()->getEnvironment() == 'dev')
  {
    echo "Looks like you need to add some items in apps/" .
      sfContext::getInstance()->getConfiguration()->getApplication() .
      "/config/app.yml under sf_traffic_cms_navigation<br/>";
  }
  return;
}

$routes = sfContext::getInstance()->getRouting()->getRoutes();
//var_dump($config['items']);
?>
<ul id="<?php echo $config['id'] ?>">
<?php foreach ($config['items'] as $name => $options): ?>
  <?php if (isset($options['permissions'])): ?>
    <?php if ($options['permissions'] == 'any' && count($sf_user->getCredentials()) == 0): continue; ?>
    <?php elseif ($options['permissions'] == 'none' && count($sf_user->getCredentials()) != 0): continue; ?>
    <?php elseif (!in_array($options['permissions'], array('any', 'none')) && !$sf_user->hasCredentials($options['permissions'])): continue; ?>
    <?php endif ?>
  <?php endif ?>
  <?php $route = $options['route']; ?>
  <?php $defaults = isset($routes[$route]) ? $routes[$route]->getDefaults() : array() ?>
  <?php $attributes = empty($options['attributes']) ? array() : $options['attributes'] ?>
  <?php $module = isset($defaults['module']) ? $defaults['module'] : null; ?>
  <?php $attributes = array_merge($attributes, array('class' => 'nav' . ($currentModule == $module ? ' active' : ''))) ?>
  <li><?php echo link_to($name, (isset($routes[$route]) ? '@' : '') . $route, $attributes) ?></li>
<?php endforeach ?>
</ul>