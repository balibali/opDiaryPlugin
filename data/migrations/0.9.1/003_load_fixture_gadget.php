<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opDiaryPluginMigrationVersion3
 *
 * load fixture gadget
 *
 * @package    opDiaryPlugin
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class opDiaryPluginMigrationVersion3 extends Doctrine_Migration_Base
{
  public function migrate($direction)
  {
    $gadgets = array(
      array('type' => 'contents', 'name' => 'diaryCommentHistory'),
      array('type' => 'profileContents', 'name' => 'diaryMemberList'),
      array('type' => 'mobileContents', 'name' => 'diaryFriendList'),
      array('type' => 'mobileContents', 'name' => 'diaryList'),
      array('type' => 'mobileContents', 'name' => 'diaryCommentHistory'),
      array('type' => 'mobileContents', 'name' => 'diaryMyList'),
      array('type' => 'mobileProfileContents', 'name' => 'diaryMemberList'),
    );

    foreach ($gadgets as $gadget)
    {
      Doctrine_Query::create()->delete('gadget')
        ->where('type = ?', $gadget['type'])
        ->andWhere('name = ?', $gadget['name'])
        ->execute();
    }
  }
}
