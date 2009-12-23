<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * PluginDiaryCommentImage
 *
 * @package    opDiaryPlugin
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
abstract class PluginDiaryCommentImage extends BaseDiaryCommentImage
{
  public function preSave($event)
  {
    $this->setFileNamePrefix();
  }

  public function postSave($event)
  {
    $this->DiaryComment->has_images = true;
    $this->DiaryComment->save();
  }

  protected function setFileNamePrefix()
  {
    $prefix = 'dc_'.$this->getDiaryComment()->getId().'_';

    $file = $this->getFile();
    $file->setName($prefix.$file->getName());
  }

  public function preDelete($event)
  {
    $this->getFile()->getFileBin()->delete();
    $this->getFile()->delete();
  }
}
