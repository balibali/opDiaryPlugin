<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opDiaryPluginRoutingBackend
 *
 * @package    OpenPNE
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class opDiaryPluginRoutingBackend
{
  static public function getRoutes()
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
