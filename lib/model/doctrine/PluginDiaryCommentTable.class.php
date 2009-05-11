<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * PluginDiaryCommentTable
 *
 * @package    opDiaryPlugin
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
abstract class PluginDiaryCommentTable extends Doctrine_Table
{
  public function getMaxNumber($diaryId)
  {
    return (int)$this->createQuery()
      ->select('MAX(number)')
      ->where('diary_id = ?', $diaryId)
      ->execute(array(), Doctrine::HYDRATE_SINGLE_SCALAR);
  }
}
