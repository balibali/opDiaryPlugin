<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opDiaryPluginMigrationVersion5
 *
 * add column is_open on diary
 *
 * @package    opDiaryPlugin
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class opDiaryPluginMigrationVersion5 extends opMigration
{
  public function up()
  {
    $options = array('notnull' => true, 'default' => 0);
    $this->addColumn('diary', 'is_open', 'boolean', null, $options);
  }

  public function postUp()
  {
    Doctrine_Query::create()
      ->update('Diary')
      ->set('public_flag', '?', 1)
      ->set('is_open', '?', true)
      ->where('public_flag = ?', 4)
      ->execute();
  }

  public function down()
  {
    $this->removeColumn('diary', 'is_open');
  }

  public function preDown()
  {
    Doctrine_Query::create()
      ->update('Diary')
      ->set('public_flag', '?', 4)
      ->where('is_open = ?', true)
      ->execute();
  }
}
