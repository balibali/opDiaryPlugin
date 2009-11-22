<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opDiaryPluginMigrationVersion4
 *
 * fix a foreign key on `diary_comment`
 *
 * @package    opDiaryPlugin
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class opDiaryPluginMigrationVersion4 extends opMigration
{
  public function up()
  {
    $this->dropForeignKey('diary_comment', 'diary_comment_diary_id_diary_id');

    $definition = array(
        'local'        => 'diary_id',
        'foreign'      => 'id',
        'foreignTable' => 'diary',
        'onDelete'     => 'CASCADE',
        );
    $this->createForeignKey('diary_comment', 'diary_comment_diary_id_diary_id', $definition);
  }
}
