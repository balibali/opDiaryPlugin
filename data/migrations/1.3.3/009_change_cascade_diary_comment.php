<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opDiaryPluginMigrationVersion9
 *
 * change the foreign key reference to `member` on `diary_comment` from onDelete CASCADE to SET NULL
 *
 * @package    opDiaryPlugin
 * @author     Maki TAKAHASHI <takahashi@tejimaya.com>
 */
class opDiaryPluginMigrationVersion9 extends opMigration
{
  public function preUp()
  {
    Doctrine::getTable('DiaryComment')->createQuery()->update()
      ->set('DiaryComment.member_id', 'NULL')
      ->where('DiaryComment.member_id NOT IN (SELECT Member.id FROM Member)')
      ->execute();
  }

  public function preDown()
  {
    Doctrine::getTable('DiaryComment')->createQuery()->update()
      ->set('DiaryComment.member_id', 'NULL')
      ->where('DiaryComment.member_id NOT IN (SELECT Member.id FROM Member)')
      ->execute();
  }

  public function up()
  {
    $option = array(
      'notnull' => false,
    );
    $this->changeColumn('diary_comment', 'member_id', 'integer', '4', $option);

    $this->dropForeignKey('diary_comment', 'diary_comment_member_id_member_id');

    $definition = array(
        'local'        => 'member_id',
        'foreign'      => 'id',
        'foreignTable' => 'member',
        'onDelete'     => 'SET NULL',
        );
    $this->createForeignKey('diary_comment', 'diary_comment_member_id_member_id', $definition);
  }

  public function down()
  {
    $option = array(
      'notnull' => true,
    );
    $this->changeColumn('diary_comment', 'member_id', 'integer', '4', $option);

    $this->dropForeignKey('diary_comment', 'diary_comment_member_id_member_id');

    $definition = array(
        'local'        => 'member_id',
        'foreign'      => 'id',
        'foreignTable' => 'member',
        'onDelete'     => 'CASCADE',
        );
    $this->createForeignKey('diary_comment', 'diary_comment_member_id_member_id', $definition);
  }
}
