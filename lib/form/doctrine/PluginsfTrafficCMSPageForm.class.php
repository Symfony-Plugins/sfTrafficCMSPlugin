<?php

/**
 * PluginsfTrafficCMSPage form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginsfTrafficCMSPageForm extends BasesfTrafficCMSPageForm
{
  public function configure()
  {
    $useFields = array(
      'title',
      'body_copy'
    );

    if (sfContext::hasInstance() && sfContext::getInstance()->getUser()->isSuperAdmin())
    {
      $useFields = array_merge(array('has_sub_pages'), $useFields);
    }

    if ($this->getObject()->has_sub_pages)
    {
      $extras = array(
        'embedded_c_m_s_page_image',
        'new_c_m_s_page_image',
        'embedded_sf_traffic_c_m_s_sub_page',
        'new_sf_traffic_c_m_s_sub_page',
      );

      foreach ($extras as $field)
      {
        if (isset($this->widgetSchema[$field]))
        {
          $useFields[] = $field;
        }
      }
    }

    $this->useFields($useFields);
  }
}
