<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

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
    unset($this['has_images']);

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
      if (!$this->isNew())
      {
        sfContext::getInstance()->getConfiguration()->loadHelpers('Partial');
        $images = $this->getObject()->getDiaryImages();
      }

      $options = array(
        'file_src'     => '',
        'is_image'     => true,
        'with_delete'  => true,
        'delete_label' => 'remove the current photo',
      );

      $max = (int)sfConfig::get('app_diary_max_image_file_num', 3);
      for ($i = 1; $i <= $max; $i++)
      {
        $key = 'photo_'.$i;

        if (!$this->isNew() && !empty($images[$i]))
        {
          $options['edit_mode'] = true;
          $options['template'] = get_partial('diary/formEditImage', array('image' => $images[$i]));
          $this->setValidator($key.'_delete', new sfValidatorBoolean(array('required' => false)));
        }
        else
        {
          $options['edit_mode'] = false;
        }

        $this->setWidget($key, new sfWidgetFormInputFileEditable($options));
        $this->setValidator($key, new opValidatorImageFile(array('required' => false)));
      }
    }
  }

  public function save($con = null)
  {
    $diary = parent::save();

    if (!$this->isNew())
    {
      $images = $this->getObject()->getDiaryImages();
    }

    if (sfConfig::get('app_diary_is_upload_images', true))
    {
      $max = (int)sfConfig::get('app_diary_max_image_file_num', 3);
      for ($i = 1; $i <= $max; $i++)
      {
        $key = 'photo_'.$i;

        if ($this->getValue($key.'_delete'))
        {
          $images[$i]->delete();
        }

        if ($this->getValue($key))
        {
          if (!empty($images[$i]) && !$images[$i]->isDeleted())
          {
            $images[$i]->delete();
          }

          $file = new File();
          $file->setFromValidatedFile($this->getValue($key));
          $file->setName('d_'.$diary->getId().'_'.$file->getName());

          $image = new DiaryImage();
          $image->setDiary($diary);
          $image->setFile($file);
          $image->setNumber($i);
          $image->save();
        }
      }
    }

    return $diary;
  }
}
