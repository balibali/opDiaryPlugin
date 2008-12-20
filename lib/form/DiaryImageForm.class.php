<?php

/**
 * DiaryImage form.
 *
 * @package    OpenPNE
 * @subpackage form
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class DiaryImageForm extends BaseDiaryImageForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'file1' => new sfWidgetFormInputFile(),
      'file2' => new sfWidgetFormInputFile(),
      'file3' => new sfWidgetFormInputFile(),
    ));
    $this->setValidators(array(
      'file1' => new opValidatorImageFile(array('required' => false)),
      'file2' => new opValidatorImageFile(array('required' => false)),
      'file3' => new opValidatorImageFile(array('required' => false)),
    ));
  }
}
