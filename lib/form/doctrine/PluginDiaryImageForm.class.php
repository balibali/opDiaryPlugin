<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * PluginDiaryImage form.
 *
 * @package    opDiaryPlugin
 * @subpackage form
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
abstract class PluginDiaryImageForm extends BaseDiaryImageForm
{
  public function setup()
  {
    parent::setup();

    unset($this['id']);
    $this->useFields();

    $key = 'photo';

    $options = array(
        'file_src'     => '',
        'is_image'     => true,
        'with_delete'  => true,
        'delete_label' => sfContext::getInstance()->getI18N()->__('remove the current photo'),
        'label'        => false,
        'edit_mode'    => !$this->isNew(),
        );

    if (!$this->isNew())
    {
      sfContext::getInstance()->getConfiguration()->loadHelpers('Partial');
      $options['template'] = get_partial('diary/formEditImage', array('image' => $this->getObject()));
      $this->setValidator($key.'_delete', new sfValidatorBoolean(array('required' => false)));
    }

    $this->setWidget($key, new sfWidgetFormInputFileEditable($options, array('size' => 40)));
    $this->setValidator($key, new opValidatorImageFile(array('required' => false)));
  }

  public function updateObject($values = null)
  {
    $image = $this->getObject();

    if ($values['photo'] instanceof sfValidatedFile)
    {
      if (!$this->isNew())
      {
        unset($image->File);
      }

      $file = new File();
      $file->setFromValidatedFile($values['photo']);

      $image->setFile($file);
    }
    else
    {
      if (!$this->isNew() && !empty($values['photo_delete']))
      {
        $image->File->delete();
        $image->setFile(null);

        // todo: generally not model name but alias name for the parent table
        $this->getParentObject()->unlink($this->getModelName(), $image->id);
      }
    }
  }

  public function getParentModelName()
  {
    return 'Diary';
  }

  public function getParentObject()
  {
    return $this->getObject()->get($this->getParentModelName());
  }
}
