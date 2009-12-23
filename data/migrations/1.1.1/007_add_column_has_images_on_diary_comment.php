<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opDiaryPluginMigrationVersion7
 *
 * add column has_images on diary_comment
 *
 * @package    opDiaryPlugin
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class opDiaryPluginMigrationVersion7 extends opMigration
{
  public function up()
  {
    $options = array('notnull' => true, 'default' => 0);
    $this->addColumn('diary_comment', 'has_images', 'boolean', null, $options);
  }

  public function postUp()
  {
    Doctrine_Query::create()
      ->update('DiaryComment d')
      ->set('d.has_images', '?', true)
      ->where('d.id IN (SELECT DISTINCT d2.diary_comment_id FROM DiaryCommentImage d2)')
      ->execute();
  }

  public function down()
  {
    $this->removeColumn('diary_comment', 'has_images');
  }
}
