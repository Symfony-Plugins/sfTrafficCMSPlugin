<?php

/**
 * sfWidgetFormInputFileInputImageJCroppable represents an upload HTML input tag which will
 * also display the uploaded image with the JCrop functionality.
 *
 * @author     Rich Birch <rich@trafficdigital.com>
 */
class sfWidgetFormInputDummy extends sfWidgetFormInput
{
  protected function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);

    $this->addRequiredOption('text');
  }

  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    return $this->options['text'];
  }
}