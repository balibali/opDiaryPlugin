<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opDiaryPluginMigrationVersion8
 *
 * add foreign key on diary_comment_unread
 *
 * CONSTRAINT `diary_comment_unread_diary_id_diary_id` FOREIGN KEY (`diary_id`) REFERENCES `diary` (`id`) ON DELETE CASCADE
 *
 * @package    opDiaryPlugin
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class opDiaryPluginMigrationVersion8 extends opMigration
{
  public function preUp()
  {
    Doctrine::getTable('DiaryCommentUnread')->createQuery()->delete()
      ->where('DiaryCommentUnread.diary_id NOT IN (SELECT Diary.id FROM Diary)')
      ->execute();
  }

  public function up()
  {
    $this->createForeignKey('diary_comment_unread', 'diary_comment_unread_diary_id_diary_id', array(
      'name'         => 'diary_comment_unread_diary_id_diary_id',
      'local'        => 'diary_id',
      'foreign'      => 'id',
      'foreignTable' => 'diary',
      'onDelete'     => 'cascade',
    ));
  }
}
