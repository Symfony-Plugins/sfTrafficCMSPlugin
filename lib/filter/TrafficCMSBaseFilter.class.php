<?php

class TrafficCMSBaseFilter extends sfFormFilterDoctrine
{
  public function getModelName()
  {

  }

  public function getFields()
  {
    
  }

  public function setup()
  {
    if ($this->getTable()->hasTemplate('Doctrine_Template_TrafficCMS'))
    {
      $this->autoConfigure();
    }
  }

  private function autoConfigure()
  {
    $config = sfConfig::get('app_sf_traffic_cms_plugin_auto_configure', array());

    if (!isset($config['date_format']))
    {
      $config['date_format'] = '%day%/%month%/%year%';
    }
    
    foreach ($this->getWidgetSchema()->getFields() as $name => $widget)
    {
      if ($widget instanceof sfWidgetFormFilterDate)
      {
        $this->getWidget($name)->getOption('from_date')->setOption('format', $config['date_format']);
        $this->getWidget($name)->getOption('to_date')->setOption('format', $config['date_format']);
      }
    }
  }
}
