<?php

/**
 * PluginsfTrafficCMSContent form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginsfTrafficCMSContentForm extends BasesfTrafficCMSContentForm
{
  public function configure()
  {
    $object = $this->getObject();
    
    if (!$object->isNew())
    {
      if (in_array($object->type, array('text', 'integer', 'float')))
      {
        $this->widgetSchema['value'] = new sfWidgetFormInputText();
      }
      else if ($object->type == 'textarea')
      {
        $this->widgetSchema['value'] = new sfWidgetFormTextarea();
      }
      
      if ($object->type == 'integer')
      {
        $this->validatorSchema['value'] = new sfValidatorInteger();
      }
      else if ($object->type == 'float')
      {
        $this->validatorSchema['value'] = new sfValidatorNumber();
      }
      
      if ($object->type == 'integer')
      {
        $this->validatorSchema['value'] = new sfValidatorInteger();
      }
      
      $this->widgetSchema['value']->setOption('label', $object->name);
    }
    
    $fields = array(
        'value'
    );
    
    $this->useFields($fields);
  }
}
