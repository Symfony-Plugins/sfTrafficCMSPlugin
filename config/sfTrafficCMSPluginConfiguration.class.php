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
      
      $this->dispatcher->connect('controller.change_action', array(
          'sfTrafficCMSTools', 'appendSeoContent',
        ));
    }
  }
}
