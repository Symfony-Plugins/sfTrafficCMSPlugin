<?php

class Doctrine_Template_TrafficCMS extends Doctrine_Template
{
  /**
  * __construct
  *
  * @param string $array
  * @return void
  */
  public function __construct(array $options = array())
  {
    $this->_options = Doctrine_Lib::arrayDeepMerge($this->_options, $options);
    
  }

  /**
   * Set table definition for TrafficCMS behavior
   *
   * @return void
   */
  public function setTableDefinition()
  {
    $this->addListener(new Doctrine_Template_Listener_TrafficCMS($this->_options));
  }

  public function getDeleteLinkFor($object)
  {
    $invoker = $this->getInvoker();

    return link_to('Delete', "@sfTrafficCMSPluginDeleteChildren?" .
      'model=' . get_class($object) . '&' .
      'id=' . $object->getId() . '&' .
      'parent_model=' . get_class($invoker) . '&' .
      'parent_model_id=' . $invoker->getId());
  }
  
  public function getAdminLink()
  {
    if (!sfContext::getInstance()->getUser()->isAuthenticated())
    {
      return '';
    }

    $invoker = $this->getInvoker();

    $route_name =
      strtolower(
        preg_replace(
          array('/([A-Z]+)([A-Z][a-z])/', '/([a-z\d])([A-Z])/'),
          '\\1_\\2',
          preg_replace('/(?:^|_)(.?)/e',"strtoupper('$1')", $invoker->getTable()->getTableName())
        )
      );
    
    $route = '@' . $route_name . '_edit?id=' . $invoker->id;

    $c = sfContext::getInstance();
    $c->switchTo('backend');
    $url = str_replace('frontend', 'backend', url_for($route));
    $c->switchTo('frontend');

    return link_to('edit', $url, array('target' => '_traffic_cms_admin'));
  }

  public function getWithAdminLink($fieldName, $load = true)
  {
    return $this->getInvoker()->get($fieldName) . $this->getAdminLink();
  }
}