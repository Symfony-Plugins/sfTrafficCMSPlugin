<?php

class sfCMSImage {
  
  public static function get($category, $name, $default = '')
  {
    if ($content = sfTrafficCMSImageTable::getInstance()->findOneBycategoryAndName($category, $name))
    {
      return $content;
    }
    
    return $default;
  }
  
  public static function getAll($category, $name)
  {
    $images = array();
    
    foreach (sfTrafficCMSImageTable::getInstance()->findByCategoryAndName($category, $name) as $content)
    {
      $images[] = $content;
    }
    
    return $images;
  }
  
  public static function getSrc($category, $name, $default = '')
  {
    if ($content = self::get($category, $name, $default))
    {
      return $content->getImageSrc('main');
    }
    
    return $default;
  }
  
  public static function getSrcAll($category, $name)
  {
    $values = array();
    
    foreach (self::getAll($category, $name) as $content)
    {
      $values[] = $content->getImageSrc('main');
    }
    
    return $values;
  }
  
  public static function getAlt($category, $name, $default = '')
  {
    if ($content = self::get($category, $name, $default))
    {
      return $content->alt;
    }
    
    return $default;
  }
  
  public static function getAltAll($category, $name)
  {
    $values = array();
    
    foreach (self::getAll($category, $name) as $content)
    {
      $values[] = $content->alt;
    }
    
    return $values;
  }
}