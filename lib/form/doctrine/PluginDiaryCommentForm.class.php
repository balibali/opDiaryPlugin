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
    $this->useFields(array('body'));

    $this->validatorSchema['body'] = new opValidatorString(array('rtrim' => true));

    if (sfConfig::get('app_diary_comment_is_upload_images', true))
    {
      $max = (int)sfConfig::get('app_diary_comment_max_image_file_num', 3);
      for ($i = 1; $i <= $max; $i++)
      {
        $key = 'photo_'.$i;

        $image = new DiaryCommentImage();
        $image->setDiaryComment($this->getObject());

        $imageForm = new DiaryCommentImageForm($image);
        $imageForm->getWidgetSchema()->setFormFormatterName('list');
        $this->embedForm($key, $imageForm, '<ul id="diary_comment_'.$key.'">%content%</ul>');
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
}
