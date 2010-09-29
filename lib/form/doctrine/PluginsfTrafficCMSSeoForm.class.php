<?php

/**
 * PluginsfTrafficCMSSeo form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginsfTrafficCMSSeoForm extends BasesfTrafficCMSSeoForm
{
  public function setup()
  {
    parent::setup();
    $this->configurePlugin();
  }
  
  public function configurePlugin()
  {

    
    unset($this['route']);
  }

}
