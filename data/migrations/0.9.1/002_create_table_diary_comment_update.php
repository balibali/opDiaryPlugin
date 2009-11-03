<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opDiaryPluginMigrationVersion2
 *
 * create table `diary_comment_update`
 *
 * @package    opDiaryPlugin
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class opDiaryPluginMigrationVersion2 extends opMigration
{
  public function migrate($direction)
  {
    $conn = Doctrine_Manager::connection();
    $list = $conn->import->listTables();

    if ('up' === $direction && in_array('diary_comment_update', $list))
    {
      return null;
    }

    $columns = array(
      'diary_id' => array('type' => 'integer', 'length' => 4, 'notnull' => true, 'primary' => true, 'default' => 0),
      'member_id' => array('type' => 'integer', 'length' => 4, 'notnull' => true, 'primary' => true, 'default' => 0),
      'last_comment_time' => array('type' => 'timestamp', 'notnull' => true),
      'my_last_comment_time' => array('type' => 'timestamp', 'notnull' => true),
    );

    $options = array(
      'charset'     => 'utf8',
      'foreignKeys' => array(
        array(
          'name'         => 'diary_comment_update_member_id_member_id',
          'local'        => 'member_id',
          'foreign'      => 'id',
          'foreignTable' => 'member',
          'onDelete'     => 'CASCADE',
        ),
        array(
          'name'         => 'diary_comment_update_diary_id_diary_id',
          'local'        => 'diary_id',
          'foreign'      => 'id',
          'foreignTable' => 'diary',
          'onDelete'     => 'CASCADE',
        ),
      ),
      'indexes' => array(
        'member_id_last_comment_time_idx' => array(
          'fields' => array('member_id', 'last_comment_time'),
        ),
      ),
    );

    $this->table($direction, 'diary_comment_update', $columns, $options);
  }
}
