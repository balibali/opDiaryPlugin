<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * PluginDiaryImage
 *
 * @package    opDiaryPlugin
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
abstract class PluginDiaryImage extends BaseDiaryImage
{
  public function preInsert($event)
  {
    $this->setFileNamePrefix();
  }

  protected function setFileNamePrefix()
  {
    $prefix = 'd_'.$this->Diary->id.'_'.$this->number.'_';

    $file = $this->File;
    $file->setName($prefix.$file->name);
  }

  public function postDelete($event)
  {
    $this->File->delete();
  }
}
