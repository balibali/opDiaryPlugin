<?php

/**
 * Diary form.
 *
 * @package    OpenPNE
 * @subpackage form
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class DiaryForm extends BaseDiaryForm
{
  public function configure()
  {
    unset($this['id']);
    unset($this['member_id']);
    unset($this['created_at']);
    unset($this['updated_at']);

    $this->widgetSchema['title'] = new sfWidgetFormInput();

    $this->widgetSchema['public_flag'] = new sfWidgetFormChoice(array(
      'choices'  => DiaryPeer::getPublicFlags(),
      'expanded' => true,
    ));
    $this->validatorSchema['public_flag'] = new sfValidatorChoice(array(
      'choices' => array_keys(DiaryPeer::getPublicFlags()),
    ));

    if (sfConfig::get('app_diary_is_upload_images', true))
    {
      $max = (int)sfConfig::get('app_diary_max_image_file_num', 3);
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
    $diary = parent::save();

    if (sfConfig::get('app_diary_is_upload_images', true))
    {
      $max = (int)sfConfig::get('app_diary_max_image_file_num', 3);
      for ($i = 1; $i <= $max; $i++)
      {
        $key = 'photo_'.$i;
        if ($this->getValue($key))
        {
          $file = new File();
          $file->setFromValidatedFile($this->getValue($key));
          $file->setName('d_'.$diary->getId().'_'.$file->getName());

          $image = new DiaryImage();
          $image->setDiary($diary);
          $image->setFile($file);
          $image->save();
        }
      }
    }

    return $diary;
  }
}
