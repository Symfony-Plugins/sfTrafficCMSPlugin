<?php

class sfTrafficCMSTools {
  public static function convertToJQueryUIDatePicker(sfWidgetFormDate $widget, $config)
  {
    sfJSLibManager::addLib('jquery_ui');

    $widget->setOptions(array(
      'years' => array_combine($config['date_picker']['years'], $config['date_picker']['years']),
      'months' => array_combine(range(1, 12), range(1, 12)),
      'days' => array_combine(range(1, 31), range(1, 31)),
      'format' => sfConfig::get($config['date_format'], '%day%/%month%/%year%'),
        ));

    return new sfWidgetFormJQueryDate(array('date_widget' => $widget));
  }
}