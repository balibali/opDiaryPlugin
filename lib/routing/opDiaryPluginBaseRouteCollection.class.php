<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opDiaryPluginBaseRouteCollection
 *
 * @package    opDiaryPlugin
 * @subpackage routing
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
abstract class opDiaryPluginBaseRouteCollection extends sfRouteCollection
{
  public function __construct(array $options)
  {
    parent::__construct($options);

    $this->routes = $this->generateRoutes();
    $this->routes += $this->generateNoDefaults();
  }

  abstract protected function generateRoutes();

  protected function generateNoDefaults()
  {
    return array(
      'diary_nodefaults' => new sfRoute(
        '/diary/*',
        array('module' => 'default', 'action' => 'error')
      ),
      'diary_comment_nodefaults' => new sfRoute(
        '/diaryComment/*',
        array('module' => 'default', 'action' => 'error')
      ),
    );
  }
}
