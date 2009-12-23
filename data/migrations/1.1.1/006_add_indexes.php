<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opDiaryPluginMigrationVersion6
 *
 * add indexes
 *
 * @package    opDiaryPlugin
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class opDiaryPluginMigrationVersion6 extends opMigration
{
  public function migrate($direction)
  {
    $options = array('fields' => array('created_at'));
    $this->index($direction, 'diary', 'created_at_idx', $options);

    $options = array('fields' => array('member_id', 'created_at'));
    $this->index($direction, 'diary', 'member_id_created_at_idx', $options);

    $options = array('fields' => array('public_flag', 'created_at'));
    $this->index($direction, 'diary', 'public_flag_craeted_at_idx', $options);

    $options = array('fields' => array('is_open', 'created_at'));
    $this->index($direction, 'diary', 'is_open_created_at_idx', $options);

    $options = array('fields' => array('diary_id', 'number'));
    $this->index($direction, 'diary_comment', 'diary_id_number_idx', $options);
  }
}
