<?php


class sfTrafficCMSPluginConfiguration extends sfPluginConfiguration
{
  /**
   * @see sfPluginConfiguration
   */
  public function initialize()
  {
    $this->dispatcher->connect('routing.load_configuration', array(
        'sfTrafficCMSRouting', 'simplePageRouting',
      ));

    if(class_exists('sfTrafficCMSSeoTable')){
      if(sfConfig::get('app_sf_traffic_cms_plugin_i18n')){      
        $this->dispatcher->connect('controller.change_action', array(
            'sfTrafficCMSTools', 'appendI18nSeoContent',
          ));
        
      }
      else{
        $this->dispatcher->connect('controller.change_action', array(
            'sfTrafficCMSTools', 'appendSeoContent',
          ));
      }
    }
    
  }
}
