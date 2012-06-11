<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 *
 * @since      File available since Release 1.4.1
 */

/**
 * opDiaryPluginMigrationVersion11
 *
 * Fixes wrong diary_comment.has_images flag which come from v2-v3 converter.
 *
 * @package    opDiaryPlugin
 * @author     Hidenori Goto <hidenorigoto@gmail.com>
 */
class opDiaryPluginMigrationVersion11 extends opMigration
{
  public function up()
  {
    $conn = $this->getConnection();

    $conn->execute('UPDATE diary_comment SET has_images = 1 WHERE id IN (SELECT diary_comment_image.diary_comment_id FROM diary_comment_image WHERE diary_comment_image.file_id > 0)');
  }
}
