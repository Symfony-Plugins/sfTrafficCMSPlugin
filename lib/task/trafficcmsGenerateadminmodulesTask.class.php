<?php

class trafficcmsGenerateadminmodulesTask extends sfBaseTask
{
  protected function configure()
  {
    $this->addArguments(array(
      new sfCommandArgument('application', sfCommandArgument::REQUIRED, 'The application name'),
    ));

    $this->addOptions(array(
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = 'trafficcms';
    $this->name             = 'generate-admin-modules';
    $this->briefDescription = 'Generates modules as specified in app.yml';
    $this->detailedDescription = <<<EOF
The [trafficcms:generate-admin-modules|INFO] task does things.
Call it with:

  [php symfony trafficcms:generate-admin-modules|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();

    $configuration = ProjectConfiguration::getApplicationConfiguration($arguments['application'], $options['env'], true);
    sfContext::createInstance($configuration);

    $context = sfContext::getInstance();
    
    $routing = $context->getRouting();
    $nav_items = sfConfig::get('app_sf_traffic_cms_plugin_navigation');
    $config = sfConfig::get('app_sf_traffic_cms_plugin_auto_configure');

    foreach ($nav_items as $model_name => $nav_options)
    {
      if (strpos($model_name, 'sf_guard') === 0)
      {
        print("Skipping sfGuard model\n");
        continue;
      }
      
      $singleton = isset($config['models'][$model_name]['singleton']) ? $config['models'][$model_name]['singleton'] : false;
      $route_name = $model_name . ($singleton ? '_edit' : '');

//      print("Checking $route_name... ");
//
//      if ($routing->hasRouteName($route_name))
//      {
//        print("found");
//      }
//      else
//      {
        $model_class_name = preg_replace('/(?:^|_)(.?)/e',"strtoupper('$1')", $model_name);

        print("Creating admin module for '$model_class_name'\n");

        $generate_admin_task = new sfDoctrineGenerateAdminTask($this->dispatcher, $this->formatter);
        $generate_admin_task->run(
          array('application' => $arguments['application'], 'route_or_model' => $model_class_name),
          array('env' => $options['env']));
//      }
      print("\n");
    }
  }
}
