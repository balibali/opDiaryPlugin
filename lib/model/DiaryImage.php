<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

class DiaryImage extends BaseDiaryImage
{
  protected $deleteFile = true;

  public function save(PropelPDO $con = null)
  {
    $result = parent::save($con);

    $this->getDiary()->updateHasImages();

    return $result;
  }

  public function delete(PropelPDO $con = null)
  {
    if ($this->deleteFile)
    {
      $this->getFile()->delete();
    }

    parent::delete($con);

    $this->getDiary()->updateHasImages();
  }

  public function setDeleteFile($value)
  {
    $this->deleteFile = $value;
  }
}
