<?php

class sfCMSContent {
  
  public static function get($category, $name, $default = '')
  {
    if ($content = sfTrafficCMSContentTable::getInstance()->findOneByCategoryAndName($category, $name))
    {
      return self::doReplacements($content->value);
    }
    
    return $default;
  }
  
  public static function getAll($category, $name)
  {
    $values = array();
    
    foreach (sfTrafficCMSContentTable::getInstance()->findByCategoryAndName($category, $name) as $content)
    {
      $values[] = self::doReplacements($content->value);
    }
    
    return $values;
  }
  
  /**
   * Looks for tokens in the form of [[category||content name]]
   * and replaces them with a matching cms content value
   * 
   * @param string $value
   * @return string
   */
  private static function doReplacements($value)
  {
    if (!preg_match_all('/\[\[(.+)\|\|(.+)\]\]/', $value, $matches))
    {
      return $value;
    }
    
    foreach ($matches[0] as $index => $match)
    {
      $category = $matches[1][$index];
      $name = $matches[2][$index];
      
      $replacement = sfCMSContent::get($category, $name);
      
      $value = str_replace($match, $replacement, $value);
    }
    
    return $value;
  }
}