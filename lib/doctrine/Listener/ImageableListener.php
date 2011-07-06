<?php

class Doctrine_Template_Listener_Imageable extends Doctrine_Record_Listener
{
  /**
  * Array of ageable options
  *
  * @var array
  */
  protected $_options = array();

  /**
  * __construct
  *
  * @param array $options
  * @return void
  */
  public function __construct(array $options)
  {
    $this->_options = $options;
  }
  
  public function postInsert(Doctrine_Event $event)
  {
    $invoker = $event->getInvoker();
    
    foreach ($this->_options['images'] as $field_name) {
      if (!$invoker->hasImageSrc($field_name) && !sfContext::hasInstance())
      {
        $invoker->loadDefaultImages($field_name);
      }
    }
  }
}