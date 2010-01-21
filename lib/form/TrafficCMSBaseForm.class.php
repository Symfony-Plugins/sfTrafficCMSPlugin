<?php

class TrafficCMSBaseForm extends sfFormDoctrine
{
  public function getModelName()
  {
  }

  public function setup()
  {
    if ($this->getObject()->getTable()->hasTemplate('Doctrine_Template_TrafficCMS'))
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
      }
    }

    // call parent bind method
    parent::bind($taintedValues, $taintedFiles);

  }

  private function removeEmptyEmbeddedFormFields(&$taintedValues, &$taintedFiles, $embedded_models)
  {
    foreach ($embedded_models as $model_name_to_embed => $options) {
      if (!isset($options['file_field']))
      {
        continue;
      }

      $model_class_name = preg_replace('/(?:^|_)(.?)/e',"strtoupper('$1')", $model_name_to_embed);

      // remove the embedded new form if the name field was not provided
      if (empty($taintedFiles['new_' . $model_name_to_embed][$options['file_field']]['tmp_name'])) {

        unset($this->embeddedForms['new_' . $model_name_to_embed]);

        // pass the new form validations
        $this->validatorSchema['new_' . $model_name_to_embed] = new sfValidatorPass();
      }
    }
  }

  private function autoConfigure()
  {
    $config = sfConfig::get('app_sf_traffic_cms_plugin_auto_configure');
    $object = $this->getObject();

    if (empty($config['models'])
        || (!array_key_exists('all', $config['models'])
          && !array_key_exists($object->getTable()->getTableName(), $config['models'])))
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
          'width' => $config['tiny_mce']['width'],
          'height' => $config['tiny_mce']['height'],
          'config' => $config['tiny_mce']['config'],
        )));
      }
      else if ($widget instanceof sfWidgetFormDate)
      {
        sfJSLibManager::addLib('jquery_ui');

        $this->setWidget($name, new sfWidgetFormJQueryDate(array(
            'format' => sfConfig::get('app_sf_traffic_cms_plugin_date_format', $config['date_format']),
            'can_be_empty' => $widget->getOption('can_be_empty'),
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
    $object = $this->getObject();

    $embedded_form_name = 'embedded_' . $model_name;
    $form_to_embed = new sfForm(null, array('id' => 'Sortable' . $model_name));
    $widgets = array();
    $object_count = 0;

    $model_class = preg_replace('/(?:^|_)(.?)/e',"strtoupper('$1')", $model_name);
    //foreach ($object->{$model_name . 's'} as $object_to_embed)

    foreach ($object->get($model_class . 's') as $object_to_embed)
    {

      $object_count++;

      $widget_name = $model_name . '_' . $object_to_embed->getId();
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

      $widgets[] = $form_to_embed->getWidget($widget_name);

    }

    $this->embedForm($embedded_form_name, $form_to_embed);

    $this->setWidgetSchema(
      $this->getWidgetSchema()->setLabel(
        $embedded_form_name,
        isset($options['form_label'])
          ? $options['form_label']
          : ucfirst(str_replace('_', ' ', $model_name))
      )
    );

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