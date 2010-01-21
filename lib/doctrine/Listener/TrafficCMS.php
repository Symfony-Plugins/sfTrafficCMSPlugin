<?php

class Doctrine_Template_Listener_TrafficCMS extends Doctrine_Record_Listener
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
}