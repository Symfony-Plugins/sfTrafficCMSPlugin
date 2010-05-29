<?php

/**
 * PluginsfTrafficCMSSubPage form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginsfTrafficCMSSubPageForm extends BasesfTrafficCMSSubPageForm
{
  public function configure()
  {
    $useFields = array('parent_id', 'title', 'body_copy');

    $extras = array(
      'embedded_c_m_s_sub_page_image',
      'new_c_m_s_sub_page_image',
      '_delete_embedded',
    );

    foreach ($extras as $field)
    {
      if (isset($this->widgetSchema[$field]))
      {
        $useFields[] = $field;
      }
    }

    $this->useFields($useFields);
  }
}
