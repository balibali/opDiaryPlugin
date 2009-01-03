<?php

/**
 * DiaryComment form.
 *
 * @package    OpenPNE
 * @subpackage form
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class DiaryCommentForm extends BaseDiaryCommentForm
{
  public function configure()
  {
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
        $this->setWidget($key, new sfWidgetFormInputFile());
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
