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
 * opDiaryPluginMigrationVersion10
 *
 * Remove invalid diary_comment_update records which come from v2-v3 converter.
 *
 * @package    opDiaryPlugin
 * @author     Hidenori Goto <hidenorigoto@gmail.com>
 */
class opDiaryPluginMigrationVersion10 extends opMigration
{
  public function up()
  {
    $conn = $this->getConnection();
    $conn->execute('DELETE FROM diary_comment_update WHERE member_id NOT IN (SELECT member.id FROM member)');
  }
}
