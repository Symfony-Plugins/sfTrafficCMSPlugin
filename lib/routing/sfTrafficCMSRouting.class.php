<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfGuardRouting.class.php 23319 2009-10-25 12:22:23Z Kris.Wallsmith $
 */
class sfTrafficCMSRouting
{
  /**
   * Listens to the routing.load_configuration event.
   *
   * @param sfEvent An sfEvent instance
   * @static
   */
  static public function simplePageRouting(sfEvent $event)
  {
    if(sfConfig::get('app_sf_traffic_cms_plugin_use_i18n', false)){
      self::simplePageI18nRouting($event);
      return;
    }
    $r = $event->getSubject();
    
    $r->appendRoute('simple_page',
      new sfDoctrineRoute(
        '/:slug',
        array('module' => 'sfTrafficCMSPlugin', 'action' => 'simplePage'), // defaults
        array(), // requirements
        array('model' => 'sfTrafficCMSPage', 'type' => 'object')  // options
    ));

    $r->appendRoute('simple_sub_page',
      new sfRequestRoute(
        '/:parentslug/:slug',
        array('module' => 'sfTrafficCMSPlugin', 'action' => 'showSubPage') // defaults
    ));
  }

  static public function simplePageI18nRouting(sfEvent $event)
  {
      $r = $event->getSubject();
      
      $r->prependRoute('simple_page',
      new sfDoctrineRoute(
        '/:sf_culture/page/:slug',
        array('module' => 'sfTrafficCMSi18nPlugin', 'action' => 'simplePage'), // defaults
        array(), // requirements
        array('model' => 'sfTrafficCMSI18nPage', 'type' => 'object')  // options
      ));

      $r->prependRoute('simple_sub_page',
        new sfRequestRoute(
          '/:sf_culture/page/:parentslug/:slug',
          array('module' => 'sfTrafficCMSi18nPlugin', 'action' => 'showSubPage') // defaults
      ));
    
  }
}

#simple_sub_page:
#  url:  /:parentslug/:slug
#  params: { module: sfTrafficCMSPlugin, action: showSubPage }