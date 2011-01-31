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
    $request = sfContext::getInstance()->getRequest();
    $path_info_array = $request->getPathInfoArray();
    
    $url = isset($path_info_array['PATH_INFO']) ? $path_info_array['PATH_INFO'] : '/' ;
    
    $pageSEOContent =  sfTrafficCMSSeoTable::getInstance()->findOneByUrl($url);
    if(!$pageSEOContent instanceof sfTrafficCMSSeo )
    {
      $route = sfContext::getInstance()->getRouting()->getCurrentRouteName();
      $pageSEOContent =  sfTrafficCMSSeoTable::getInstance()->findOneByRoute($route);
    }
    if($pageSEOContent instanceof sfTrafficCMSSeo)
    {
      $response->setTitle($pageSEOContent->title);
      $response->addHttpMeta('description', $pageSEOContent->meta_description);
      $response->addHttpMeta('keywords', $pageSEOContent->meta_keywords);
    }
    else{
      $response->setTitle('no seo content found for: '.$url.' '.$route);
      
      
    }
  }
  public static function appendI18nSeoContent(sfEvent $event )
  {
    $response = sfContext::getInstance()->getResponse();
    $request = sfContext::getInstance()->getRequest();
    $path_info_array = $request->getPathInfoArray();

    $url = isset($path_info_array['PATH_INFO']) ? $path_info_array['PATH_INFO'] : $path_info_array['REQUEST_URI'] ;

    $pageSEOContent =  sfTrafficCMSI18nSeoTable::getInstance()->findOneByUrl($url);
    if(!$pageSEOContent instanceof sfTrafficCMSSeo )
    {
      $route = sfContext::getInstance()->getRouting()->getCurrentRouteName();
      $pageSEOContent =  sfTrafficCMSSeoTable::getInstance()->findOneByRoute($route);
    }
    if($pageSEOContent instanceof sfTrafficCMSSeo)
    {
      $response->setTitle($pageSEOContent->title);
      $response->addHttpMeta('description', $pageSEOContent->meta_description);
      $response->addHttpMeta('keywords', $pageSEOContent->meta_keywords);
    }
  }
}