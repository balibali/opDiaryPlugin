<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opDiaryPluginMailActions
 *
 * @package    OpenPNE
 * @subpackage diary
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class opDiaryPluginMailActions extends sfActions
{
  protected function getSubject(opMailMessage $message, $default = '')
  {
    try
    {
      $subject = $message->getHeader('subject', 'string');
      if ('' === $subject)
      {
        $subject = $default;
      }
    }
    catch (Zend_Mail_Exception $e)
    {
      $subject = $default;
    }

    return $subject;
  }

  protected function getImageFiles(opMailMessage $message, $num = null)
  {
    $files = array();

    $images = $message->getImages();

    $i = 1;
    foreach ($images as $image)
    {
      if (null !== $num && $i > $num) break;

      $validator = new opValidatorImageFile();
      $validFile = $validator->clean($image);

      $file = new File();
      $file->setFromValidatedFile($validFile);

      $files[] = $file;
      $i++;
    }

    return $files;
  }
}
