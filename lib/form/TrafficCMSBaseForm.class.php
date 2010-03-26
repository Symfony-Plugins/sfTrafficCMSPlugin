<?php

class TrafficCMSBaseForm extends sfFormDoctrine
{
  public function getModelName()
  {
  }

  public function setup()
  {
    if ((!isset($this->autoConfigure) || $this->autoConfigure == true)
        && $this->getObject()->getTable()->hasTemplate('Doctrine_Template_TrafficCMS'))
    {
      $this->autoConfigure();
    }
  }

  public function bind(array $taintedValues = null, array $taintedFiles = null)
  {
    $config = sfConfig::get('app_sf_traffic_cms_plugin_auto_configure');

    if (isset($config['models'][$this->getObject()->getTable()->getTableName()]))
    {
      $model_config = $config['models'][$this->getObject()->getTable()->getTableName()];

      if (isset($model_config['embed']))
      {
        $this->removeEmptyEmbeddedFormFields($taintedValues, $taintedFiles, $model_config['embed']);
        $this->deleteEmbeddedFormFields($taintedValues, $taintedFiles, $model_config['embed']);
      }
    }
    
    // call parent bind method
    parent::bind($taintedValues, $taintedFiles);

  }

  private function deleteEmbeddedFormFields(&$taintedValues, &$taintedFiles, $embedded_models)
  {
    foreach ($embedded_models as $model_name_to_embed => $options)
    {
      if (empty($taintedValues['embedded_' . $model_name_to_embed]))
      {
        continue;
      }

      foreach ($taintedValues['embedded_' . $model_name_to_embed] as $form_name => $values)
      {
        if (isset($values['_delete_embedded']))
        {
          unset($taintedValues['embedded_' . $model_name_to_embed][$form_name]);
          unset($taintedFiles['embedded_' . $model_name_to_embed][$form_name]);
          if (empty($taintedValues['embedded_' . $model_name_to_embed]))
          {
            unset($taintedValues['embedded_' . $model_name_to_embed]);
            unset($taintedFiles['embedded_' . $model_name_to_embed]);
          }
          continue;
          
          $form = $this->embeddedForms['embedded_' . $model_name_to_embed];
          unset($form->embeddedForms[$form_name]);
          $form->validatorSchema[$form_name] = new sfValidatorPass();

          unset($taintedValues['embedded_' . $model_name_to_embed][$form_name]['_delete_embedded']);

          $class = preg_replace('/(?:^|_)(.?)/e',"strtoupper('$1')", $model_name_to_embed);

          if ($object = Doctrine::getTable($class)->find($values['id']))
          {
            $object->delete();
          }
        }
      }
    }
  }

  private function removeEmptyEmbeddedFormFields(&$taintedValues, &$taintedFiles, $embedded_models)
  {
    foreach ($embedded_models as $model_name_to_embed => $options) {
      if (!isset($options['ignore_if_empty']))
      {
        if (isset($options['file_field']))
        {
          $options['ignore_if_empty'] = $options['file_field'];
        }
        else
        {
          continue;
        }
      }

      $model_class_name = preg_replace('/(?:^|_)(.?)/e',"strtoupper('$1')", $model_name_to_embed);

      if (isset($options['file_field']))
      {
        // remove the embedded new form if the name field was not provided
        if (empty($taintedFiles['new_' . $model_name_to_embed][$options['file_field']]['tmp_name'])) {

          unset($this->embeddedForms['new_' . $model_name_to_embed]);

          // pass the form validations
          $this->validatorSchema['new_' . $model_name_to_embed] = new sfValidatorPass();

          unset($taintedValues['new_' . $model_name_to_embed]);
        }
      }
      else
      {
        $fields = is_array($options['ignore_if_empty'])
          ? $options['ignore_if_empty']
          : array($options['ignore_if_empty']);

        foreach ($fields as $field)
        {
          if (empty($taintedValues['new_' . $model_name_to_embed][$field]))
          {
            unset($this->embeddedForms['new_' . $model_name_to_embed]);

            // pass the form validations
            $this->validatorSchema['new_' . $model_name_to_embed] = new sfValidatorPass();

            break;
          }
        }
      }
    }
  }

  private function autoConfigure()
  {
    $config = sfConfig::get('app_sf_traffic_cms_plugin_auto_configure', array());
    $object = $this->getObject();

    if (isset($config['models']['all'])
          && $config['models']['all'] == false
          && !array_key_exists($object->getTable()->getTableName(), $config['models']))
    {
      return false;
    }

    $this->configureBehaviouralWidgets($config);

    $this->configureNonBehaviouralWidgets($config);

    if (isset($config['models'][$object->getTable()->getTableName()]))
    {
      $model_config = $config['models'][$object->getTable()->getTableName()];

      if (isset($model_config['embed']) && is_array($model_config['embed']))
      {
        foreach ($model_config['embed'] as $model_name => $options)
        {
          $this->embedModel($model_name, $options);
        }
      }

      if (isset($model_config['sortable']) && is_array($model_config['sortable']))
      {
        foreach ($model_config['sortable'] as $model_name => $options)
        {
          $this->embedSortableList($model_name, $options);
        }
      }

      if (isset($model_config['fields']) && is_array($model_config['fields']))
      {
        foreach ($model_config['fields'] as $field_name => $config_options)
        {
          $this->configureField($field_name, $config_options);
        }
      }
    }

    if ($this->getOption('embedded', false))
    {
      $this->widgetSchema['_delete_embedded'] = new sfWidgetFormChoice(
        array('choices' => array('remove' => ''), 'expanded' => true, 'multiple' => true, 'label' => 'Remove')
      );
    }
  }

  private function configureField($field_name, $config)
  {
    /**
     * Get the options set for the default widget
     */
    $options = $this->getWidget($field_name)->getOptions();

    /**
     * Merge with any options specified in the config
     */
    if (!empty($config['options']))
    {
      $options = array_merge($options, $config['options']);
    }

    if (isset($config['class']))
    {
      /**
       * Create the widget specified in the config & overwrite the default with it
       */
      $this->setWidget($field_name, new $config['class']($options));
    }
    else
    {
      $this->getWidget($field_name)->setOptions($options);
    }
  }

  private function configureNonBehaviouralWidgets($config)
  {
    foreach ($this->getWidgetSchema()->getFields() as $name => $widget)
    {
      if ($widget instanceof sfWidgetFormTextarea)
      {
        sfJSLibManager::addLib('tiny_mce');

        $this->setWidget($name, new sfWidgetFormTextareaTinyMCE(array(
          'width' => isset($config['tiny_mce']['width']) ? $config['tiny_mce']['width'] : 550,
          'height' => isset($config['tiny_mce']['height']) ? $config['tiny_mce']['height'] : 350,
          'config' => isset($config['tiny_mce']['config']) ? $config['tiny_mce']['config'] : 'theme: "simple"',
        )));
      }
      else if ($widget instanceof sfWidgetFormDate)
      {
        sfJSLibManager::addLib('jquery_ui');

		$appConfig = sfConfig::get('app_sf_traffic_cms_plugin_auto_configure');
		$dateYear = array_combine($appConfig['date_picker']['years'], $appConfig['date_picker']['years']);

        $this->setWidget($name, new sfWidgetFormJQueryDate(array(
            'format' => sfConfig::get($appConfig['date_format'], $config['date_format']),
            'can_be_empty' => $widget->getOption('can_be_empty'),
			'years' => $dateYear
        )));
      }
    }
  }

  private function configureBehaviouralWidgets()
  {
    $object = $this->getObject();
    $table = $object->getTable();

    if ($table->hasTemplate('Doctrine_Template_JCroppable'))
    {
      sfJSLibManager::addLib('jcrop');

      $object->configureJCropWidgets($this);
      $object->configureJCropValidators($this);
    }

    if ($table->hasTemplate('Doctrine_Template_Sluggable'))
    {
      $slug_name = $table->getTemplate('Doctrine_Template_Sluggable')->getOption('name');

      if (isset($this[$slug_name]))
      {
        unset($this[$slug_name]);
      }
    }

    if ($table->hasTemplate('Doctrine_Template_Timestampable'))
    {
      $created = $table->getTemplate('Doctrine_Template_Timestampable')->getOption('created');

      if (isset($created['name']) && isset($this[$created['name']]))
      {
        unset($this[$created['name']]);
      }

      $updated = $table->getTemplate('Doctrine_Template_Timestampable')->getOption('updated');

      if (isset($updated['name']) && isset($this[$updated['name']]))
      {
        unset($this[$updated['name']]);
      }
    }
  }

  private function embedSortableList($model_name, $options)
  {
    $model_class_name = preg_replace('/(?:^|_)(.?)/e',"strtoupper('$1')", $model_name);

    sfJSLibManager::addLib('jquery_ui');

    $this->setWidget(
      'sortable_' . $model_name,
      new sfWidgetFormDoctrineJQueryUISortable(array(
        'model'         => $model_class_name,
        'parent_object' => $this->getObject(),
        'method'        => array($options['method'], $options['method_arguments']),
        'grid'          => isset($options['grid']) ? $options['grid'] : false,
        'table_method'  => array($options['table_method'], array($this->getObject()))
      ))
    );

    $this->getWidgetSchema()->setLabel(
      'sortable_' . $model_name,
      isset($options['form_label'])
        ? $options['form_label']
        : 'Arrange ' . str_replace('_', ' ', $model_name) . 's'
    );
  }

  private function embedModel($model_name, $options)
  {
    $options['max_records'] = isset($options['max_records']) ? $options['max_records'] : 1000000;
    
    $object = $this->getObject();

    $embedded_form_name = 'embedded_' . $model_name;
    $form_to_embed = new sfForm(null, array('id' => 'Embedded' . $model_name));
    //$widgets = array();
    $object_count = 0;

    $model_class = isset($options['foreignAlias'])
      ? $options['foreignAlias']
      : preg_replace('/(?:^|_)(.?)/e',"strtoupper('$1')", $model_name);

    $children = $object->get($model_class . 's');

    foreach ($children as $key => $object_to_embed)
    { 
      $object_count++;

      $widget_name = $model_name . '_' . $object_to_embed->getId();

      if (isset($_POST[$object->getTable()->getTableName()][$embedded_form_name][$widget_name]['_delete_embedded']))
      {
        $children->remove($key);
        continue;
      }

      $form_class = get_class($object_to_embed) . 'Form';

      $widget_form = new $form_class($object_to_embed, array(
        'embedded' => true,
        'parent_model' =>  $object,
      ));
      
      // Hide the parent id since we don't want to be able to edit it
      $widget_form->setWidget($object->getTable()->getTableName() . '_id', new sfWidgetFormInputHidden());

      $form_to_embed->embedForm($widget_name, $widget_form);

      $form_to_embed->setWidgetSchema(
        $form_to_embed->getWidgetSchema()->setLabel(
          $widget_name,
          (isset($options['label']) ? $options['label'] . ' ' : '') . $object_count
        )
      );

    }
    $children->save();
//    $object->set($model_class . 's', $children);
//    if ($object_count > 0)
//    {
      $this->embedForm($embedded_form_name, $form_to_embed);

      $this->setWidgetSchema(
        $this->getWidgetSchema()->setLabel(
          $embedded_form_name,
          isset($options['form_label'])
            ? $options['form_label']
            : ucfirst(str_replace('_', ' ', $model_name))
        )
      );
//    }

    if (!$object->isNew() && $object_count < $options['max_records']) {
      $model_class = preg_replace('/(?:^|_)(.?)/e',"strtoupper('$1')", $model_name);

      // create a new embedded field object
      $object_to_embed = new $model_class();

      $object_to_embed->{$object->getTable()->getTableName() . '_id'} = $object->getId();

      $form_class = get_class($object_to_embed) . 'Form';

      // create a new embedded field object form
      $form_to_embed = new $form_class($object_to_embed);

      // Hide the parent id since we don't want to be able to edit it
      $form_to_embed->setWidget($object->getTable()->getTableName() . '_id', new sfWidgetFormInputHidden());

      // embed the form in the current form
      $this->embedForm('new_' . $model_name, $form_to_embed);

      $this->setWidgetSchema(
        $this->getWidgetSchema()->setLabel(
          'new_' . $model_name,
          isset($options['add_new_label'])
            ? $options['add_new_label']
            : 'Add new ' . str_replace('_', ' ', $model_name)
        )
      );
    }
  }
}