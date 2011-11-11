<?php

class sfTrafficCMSPluginComponents extends sfComponents
{
  public function executeNavigationBackend(sfWebRequest $request)
  {
    
    $config = sfConfig::get('app_sf_traffic_cms_plugin_navigation');

    //$this->models = sfTrafficCMSHelper::getDisplayModels();

    //$this->checkModelsExist($this->models);
  }

  public function executeSubNav(sfWebRequest $request)
  {
    
  }

  protected function checkModelsExist($models)
  {
    $dir = getcwd();
    chdir('../');

    foreach ($models as $model)
    {
      $module = strtolower(preg_replace('/([^A-Z])([A-Z])/', "$1_$2", $model));

      if (!file_exists('apps/backend/modules/' . $module))
      {
        print("$module/index doesn't exist<br />");

        print("Please run 'php symfony doctrine:generate-admin backend $module'<br />");
      }
    }
    
    chdir($dir);
  }
}
