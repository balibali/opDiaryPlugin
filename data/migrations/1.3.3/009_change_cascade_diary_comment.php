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
  public function up()
  {
    $conn = $this->getConnection();
    $option = array(
      'notnull' => false,
    );

    $conn->export->alterTable('diary_comment',
      array(
        'change' => array(
          'member_id' => array(
            'length' => 4,
            'definition' => array(
              'type' => 'integer',
              'length' => 4,
            ),
          ),
        )
      ));

    $conn->export->dropForeignKey('diary_comment', 'diary_comment_member_id_member_id');
    $conn->execute('UPDATE diary_comment SET diary_comment.member_id=NULL WHERE diary_comment.member_id NOT IN (SELECT member.id FROM member)');

    $definition = array(
        'name'         => 'diary_comment_member_id_member_id',
        'local'        => 'member_id',
        'foreign'      => 'id',
        'foreignTable' => 'member',
        'onDelete'     => 'SET NULL',
        );
    $conn->export->createForeignKey('diary_comment', $definition);
  }
}
