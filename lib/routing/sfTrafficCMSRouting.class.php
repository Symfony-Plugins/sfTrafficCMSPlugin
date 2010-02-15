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
    $r = $event->getSubject();

    $r->appendRoute('simple_page',
      new sfDoctrineRoute(
        '/:slug',
        array('module' => 'sfTrafficCMSPlugin', 'action' => 'simplePage'), // defaults
        array(), // requirements
        array('model' => 'sfTrafficCMSPage', 'type' => 'object')  // options
    ));
  }
}