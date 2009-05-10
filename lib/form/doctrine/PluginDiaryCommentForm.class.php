<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * PluginDiaryComment form.
 *
 * @package    opDiaryPlugin
 * @subpackage form
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
abstract class PluginDiaryCommentForm extends BaseDiaryCommentForm
{
  public function setup()
  {
    parent::setup();

    unset($this['id']);
    unset($this['diary_id']);
    unset($this['member_id']);
    unset($this['number']);
    unset($this['created_at']);
    unset($this['updated_at']);

    if (sfConfig::get('app_diary_comment_is_upload_images', true))
    {
      $max = (int)sfConfig::get('app_diary_comment_max_image_file_num', 3);
      for ($i = 1; $i <= $max; $i++)
      {
        $key = 'photo_'.$i;
        $this->setWidget($key, new sfWidgetFormInputFile(array(), array('size' => 40)));
        $this->setValidator($key, new opValidatorImageFile(array('required' => false)));
      }
    }
  }

  public function save($con = null)
  {
    $comment = parent::save();

    if (sfConfig::get('app_diary_comment_is_upload_images', true))
    {
      $max = (int)sfConfig::get('app_diary_comment_max_image_file_num', 3);
      for ($i = 1; $i <= $max; $i++)
      {
        $key = 'photo_'.$i;
        if ($this->getValue($key))
        {
          $file = new File();
          $file->setFromValidatedFile($this->getValue($key));
          $file->setName('dc_'.$comment->getId().'_'.$file->getName());

          $image = new DiaryCommentImage();
          $image->setDiaryComment($comment);
          $image->setFile($file);
          $image->save();
        }
      }
    }

    return $comment;
  }
}
