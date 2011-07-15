<?php

/**
 * PluginsfTrafficCMSContent form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormFilterPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginsfTrafficCMSContentFormFilter extends BasesfTrafficCMSContentFormFilter
{
  public function setup()
  {
    parent::setup();
    
    $this->widgetSchema['category'] = new sfWidgetFormDoctrineChoice(array(
        'model'         => 'sfTrafficCMSContent',
        'table_method'  => 'getCategories',
        'method'        => 'getCategory',
        'add_empty'     => true
    ));
  }
}
