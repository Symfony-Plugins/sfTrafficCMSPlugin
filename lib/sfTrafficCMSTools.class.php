<?php

class sfTrafficCMSTools {
  public static function convertToJQueryUIDatePicker(sfWidgetFormDate $widget, $config, $forFilter = false)
  {
    sfJSLibManager::addLib('jquery_ui');

    $widget->setOptions(array(
      'years' => array_combine($config['date_picker']['years'], $config['date_picker']['years']),
      'months' => array_combine(range(1, 12), range(1, 12)),
      'days' => array_combine(range(1, 31), range(1, 31)),
      'format' => sfConfig::get($config['date_format'], '%day%/%month%/%year%'),
      'can_be_empty' => $forFilter ? true : $widget->getOption('can_be_empty'),
        ));

    return new sfWidgetFormJQueryDate(array('date_widget' => $widget));
  }

  public static function appendSeoContent(sfEvent $event )
  {
    $response = sfContext::getInstance()->getResponse();
    $route = sfContext::getInstance()->getRouting()->getCurrentRouteName();
    
    
    $pageSEOContent =  sfTrafficCMSSeoTable::getInstance()->findOneByRoute($route);
    
    if($pageSEOContent instanceof sfTrafficCMSSeo)
    {
      $response->setTitle($pageSEOContent->title);
      $response->addHttpMeta('description', $pageSEOContent->meta_description);
      $response->addHttpMeta('keywords', $pageSEOContent->meta_keywords);
    }
  }
}