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
    foreach ($this->getWidgetSchema()->getFields() as $name => $widget)
    {
//      if ($widget instanceof sfWidgetFormFilterDate)
//      {
//        $this->setWidget($name, new sfWidgetFormJQueryDate(array(
//            'format' => sfConfig::get('app_sf_traffic_cms_plugin_date_format', $config['date_format']),
//            'can_be_empty' => $widget->getOption('can_be_empty'),
//        )));
//      }
    }
  }
}
