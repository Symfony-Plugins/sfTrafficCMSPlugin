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
  }
}
