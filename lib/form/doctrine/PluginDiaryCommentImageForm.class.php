<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * PluginDiaryCommentImage form.
 *
 * @package    opDiaryPlugin
 * @subpackage form
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
abstract class PluginDiaryCommentImageForm extends BaseDiaryCommentImageForm
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
        'label'        => false,
        'edit_mode'    => false,
        );

    $this->setWidget($key, new sfWidgetFormInputFileEditable($options, array('size' => 40)));
    $this->setValidator($key, new opValidatorImageFile(array('required' => false)));
  }

  public function updateObject($values = null)
  {
    if ($values['photo'] instanceof sfValidatedFile)
    {
      $file = new File();
      $file->setFromValidatedFile($values['photo']);

      $this->getObject()->setFile($file);
    }
    else
    {
      $this->getObject()->setFile(null);
    }
  }
}
