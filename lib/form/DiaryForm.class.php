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
    unset($this->widgetSchema['member_id']);
    $this->widgetSchema['title'] = new sfWidgetFormInput();

    unset($this['created_at']);
    unset($this['updated_at']);

    $this->mergeForm(new DiaryImageForm());
  }

  public function save($con = null)
  {
    $diary = parent::save();

    $imageKeys = array('photo_1', 'photo_2', 'photo_3');
    foreach ($imageKeys as $imageKey)
    {
      if ($this->getValue($imageKey))
      {
        $file = new File();
        $file->setFromValidatedFile($this->getValue($imageKey));
        $file->setName('d_'.$diary->getId().'_'.$file->getName());

        $image = new DiaryImage();
        $image->setDiary($diary);
        $image->setFile($file);
        $image->save();
      }
    }

    return $diary;
  }
}
