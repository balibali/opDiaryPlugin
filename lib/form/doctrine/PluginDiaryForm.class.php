<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * PluginDiary form.
 *
 * @package    opDiaryPlugin
 * @subpackage form
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
abstract class PluginDiaryForm extends BaseDiaryForm
{
  public function setup()
  {
    parent::setup();

    unset($this['id']);
    unset($this['member_id']);
    unset($this['created_at']);
    unset($this['updated_at']);
    unset($this['has_images']);

    $this->widgetSchema['title'] = new sfWidgetFormInput();
    $this->widgetSchema['body']  = new opWidgetFormRichTextareaOpenPNE();

    $this->widgetSchema['public_flag'] = new sfWidgetFormChoice(array(
      'choices'  => Doctrine::getTable('Diary')->getPublicFlags(),
      'expanded' => true,
    ));
    $this->validatorSchema['public_flag'] = new sfValidatorChoice(array(
      'choices' => array_keys(Doctrine::getTable('Diary')->getPublicFlags()),
    ));

    if (sfConfig::get('app_diary_is_upload_images', true))
    {
      $images = array();
      if (!$this->isNew())
      {
        $images = $this->getObject()->getDiaryImages();
      }

      $max = (int)sfConfig::get('app_diary_max_image_file_num', 3);
      for ($i = 1; $i <= $max; $i++)
      {
        $key = 'photo_'.$i;

        if (isset($images[$i]))
        {
          $image = $images[$i];
        }
        else
        {
          $image = new DiaryImage();
          $image->setDiary($this->getObject());
          $image->setNumber($i);
        }

        $imageForm = new DiaryImageForm($image);
        $imageForm->getWidgetSchema()->setFormFormatterName('list');
        $this->embedForm($key, $imageForm, '<ul id="diary_'.$key.'">%content%</ul>');
      }
    }
  }

  public function updateObject($values = null)
  {
    $object = parent::updateObject($values);

    foreach ($this->embeddedForms as $key => $form)
    {
      if (!($form->getObject() && $form->getObject()->getFile()))
      {
        unset($this->embeddedForms[$key]);
      }
    }

    return $object;
  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->getObject()->updateHasImages();
  }
}
