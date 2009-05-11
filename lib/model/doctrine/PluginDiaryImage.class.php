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
  protected $deleteFile = true;

  public function save(Doctrine_Connection $conn = null)
  {
    $result = parent::save($conn);

    $this->getDiary()->updateHasImages();

    return $result;
  }

  public function delete(Doctrine_Connection $conn = null)
  {
    if ($this->deleteFile)
    {
      $this->getFile()->delete();
    }

    if (!$this->isDeleted())
    {
      parent::delete($conn);
    }

    $this->getDiary()->updateHasImages();
  }

  public function setDeleteFile($value)
  {
    $this->deleteFile = $value;
  }
}
