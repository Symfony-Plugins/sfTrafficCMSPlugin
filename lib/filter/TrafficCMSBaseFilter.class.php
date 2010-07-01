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
        $from = $this->getWidget($name)->getOption('from_date');
        $to = $this->getWidget($name)->getOption('to_date');

        $widget->setOption('from_date', sfTrafficCMSTools::convertToJQueryUIDatePicker($from, $config));
        $widget->setOption('to_date', sfTrafficCMSTools::convertToJQueryUIDatePicker($to, $config));
      }
    }
  }
}
