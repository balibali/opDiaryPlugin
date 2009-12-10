<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opDiaryPluginRouting
 *
 * @package    OpenPNE
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class opDiaryPluginRouting
{
  static public function listenToRoutingLoadConfigurationEvent(sfEvent $event)
  {
    $routing = $event->getSubject();

    $app = sfContext::getInstance()->getConfiguration()->getApplication();

    switch ($app)
    {
      case 'pc_frontend':
      case 'mobile_frontend':
        $routes = opDiaryPluginRoutingFrontend::getRoutes();
        break;
      case 'pc_backend':
        $routes = opDiaryPluginRoutingBackend::getRoutes();
        break;
      default:
        $routes = array();
        break;
    }

    $routes = array_reverse($routes);
    foreach ($routes as $name => $route)
    {
      $routing->prependRoute($name, $route);
    }
  }
}
